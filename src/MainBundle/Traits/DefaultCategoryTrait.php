<?php

namespace App\MainBundle\Traits;

use App\MainBundle\Entity\Account;

/**
 * DefaultCategoryTrait
 */
trait DefaultCategoryTrait {
	public function makeUserCategories(Account $account, array $defaultCategories): array{
        $userCategories = [];

        foreach ($defaultCategories as $defaultCategory) {
            $userCategory = $defaultCategory->toUserCategory();
            $userCategory->setAccount($account);

            $userCategories[] = $userCategory;
        }

        return $userCategories;
    }
}
