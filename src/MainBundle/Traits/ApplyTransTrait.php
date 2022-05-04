<?php

namespace App\MainBundle\Traits;

use \DateTime;
use App\MainBundle\Entity\Trans;
use App\MainBundle\Enums\TransferTypes;
use DateTimeImmutable;
use DateTimeInterface;
use Doctrine\Persistence\ObjectManager;

/**
 * ApplyTransTrait
 */
trait ApplyTransTrait {
	public function applyTransaction(Trans $trans, ObjectManager $entityManager) {
        $fromWallet = $trans->getWallet();
        $toWallet = null;

        if($trans->getType() == TransferTypes::REVENUE){
            $fromWallet->setAmount(
                $fromWallet->getAmount() + $trans->getAmount()
            );
        } else if($trans->getType() == TransferTypes::EXPENSE){
            $fromWallet->setAmount(
                $fromWallet->getAmount() - $trans->getAmount()
            );
        } else if($trans->getType() == TransferTypes::TRANSFER){
            $toWallet = $trans->getTransferWallet();
            $fee = $trans->getFee();

            $fromWallet->setAmount(
                $fromWallet->getAmount() - $trans->getAmount() - $fee
            );
            $toWallet->setAmount(
                $toWallet->getAmount() + $trans->getAmount()
            );
        }

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($fromWallet);
        if(!is_null($toWallet)){
            $entityManager->persist($toWallet);
        }
        $entityManager->flush();
	}

	public function undoTransaction(Trans $trans, ObjectManager $entityManager) {
        $fromWallet = $trans->getWallet();
        $toWallet = null;

        if($trans->getType() == TransferTypes::REVENUE){
            $fromWallet->setAmount(
                $fromWallet->getAmount() - $trans->getAmount()
            );
        } else if($trans->getType() == TransferTypes::EXPENSE){
            $fromWallet->setAmount(
                $fromWallet->getAmount() + $trans->getAmount()
            );
        } else if($trans->getType() == TransferTypes::TRANSFER){
            $toWallet = $trans->getTransferWallet();
            $fee = $trans->getFee();

            $fromWallet->setAmount(
                $fromWallet->getAmount() + $trans->getAmount() + $fee
            );
            $toWallet->setAmount(
                $toWallet->getAmount() - $trans->getAmount()
            );
        }

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($fromWallet);
        if(!is_null($toWallet)){
            $entityManager->persist($toWallet);
        }
        $entityManager->flush();
	}

    private function convertToTransEntity(array $data, array $repositories = null): ?Trans{
        $walletRepository = $repositories['walletRepo'];
        $categoryRepository = $repositories['cateRepo'];

        $trans = new Trans();
        $currentUser = $this->getUser();

        if($data['id'] == ''){
            $trans->setId(-1);
        } else {
            $trans->setId($data['id']);
        }
        
        $trans->setType($data['type']);
        $trans->setWallet($walletRepository->findOneBy([
            'id' => $data['wallet']->id,
            'active' => true,
            'account' => $currentUser
        ]));
        if($trans->getType() == TransferTypes::TRANSFER){
            $trans->setTransferWallet($walletRepository->findOneBy([
                'id' => $data['transferWallet']->id,
                'active' => true,
                'account' => $currentUser
            ]));
            if(isset($data['withFee'])){
                $trans->setFee((int)$data['fee']);
            }
        }
        $trans->setAmount((int)$data['amount']);
        $trans->setNote($data['note']);
        $trans->setCategory($categoryRepository->findOneBy([
            'id' => $data['category']->id,
            'active' => true,
            'account' => $currentUser
        ]));
        $dateTime = DateTime::createFromFormat('d-m-Y H:i', $data['dateTime'] . ' 00:00');
        $trans->setDateTime($dateTime);
        $trans->setAccount($currentUser);

        return $trans;
    }
}