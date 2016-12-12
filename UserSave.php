<?php

use IugoGameLib\SuccessDocumentFactory;
use IugoGameLib\UserData\DocumentUserDataDAO;

final class UserSave extends UserDataEndpoint {

    private function mergeNode($new, $old) {
        if ($old->getValue() === $new->getValue()) {
            foreach ($old->getChildren() as $c) {
                if ($new->hasChild($c->getName())) {
                    $this->mergeNode($new->getChild($c->getName()), $c);
                } else {
                    $new->addChild($c);
                }
            }
        }
    }

    protected function generateResults($input) {
        $userData = (new DocumentUserDataDAO($input))->get();

        $dao = $this->getUserDataDAO();
        $currentDocumentData = $dao->getWith($userData->getUserId());

        if ($currentDocumentData === null) {
            $currentDocumentData = $userData;
        } else {
            $newData = $userData->getData();
            $this->mergeNode($newData, $currentDocumentData->getData());
            $currentDocumentData->setData($newData);
        }

        $dao->update($currentDocumentData);
        $dao->save();

        return (new SuccessDocumentFactory())->create();
    }
}