<?php

namespace App\ApiBundle\Security;

use App\MainBundle\Entity\Account;
use App\MainBundle\Repository\AccountRepository;
use Doctrine\ORM\EntityManagerInterface;
use Firebase\JWT\JWT;
use Symfony\Component\DependencyInjection\ParameterBag\ContainerBagInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Guard\AbstractGuardAuthenticator;

class JwtAuthenticator extends AbstractGuardAuthenticator{

	private $em;
	private $params;

	/**
	 * @var AccountRepository
	 */
	private $accountRepository;

	public function __construct(EntityManagerInterface $em, ContainerBagInterface $params, AccountRepository $accountRepository) {
		$this->em = $em;
		$this->params = $params;
		$this->accountRepository = $accountRepository;
	}

	public function start(Request $request, AuthenticationException $authException = null) {
		$data = [
			'message' => 'Authentication Required'
		];
		return new JsonResponse($data, Response::HTTP_UNAUTHORIZED);
	}

	public function supports(Request $request) {
		return $request->headers->has('Authorization');
	}

	public function getCredentials(Request $request) {
		return $request->headers->get('Authorization');
	}

	public function getUser($credentials, UserProviderInterface $userProvider) {
		try {
            $credentials = str_replace('Bearer ', '', $credentials);
            $jwt = (array) JWT::decode(
                $credentials,
                $this->params->get('jwt_secret'),
                ['HS512']
            );

            return $this->accountRepository->findOneBy([
                'email' => $jwt['user'],
            ]);
        }catch (\Exception $exception) {
            throw new AuthenticationException($exception->getMessage());
        }
	}

	public function checkCredentials($credentials, UserInterface $user) {
	}

	public function onAuthenticationFailure(Request $request, AuthenticationException $exception) {
		return new JsonResponse(
			[
				'message' => $exception->getMessage()
			],
			Response::HTTP_UNAUTHORIZED
		);
	}

	public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $providerKey) {
		return;
	}

	public function supportsRememberMe() {
		return false;
	}
}
