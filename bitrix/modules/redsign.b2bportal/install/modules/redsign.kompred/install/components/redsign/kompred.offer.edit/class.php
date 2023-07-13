<?php

use Bitrix\Main\Error;
use Bitrix\Main\Localization\Loc;

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
    die();


Loc::loadMessages(__FILE__);

\CBitrixComponent::includeComponentClass('redsign:kompred.offer.show');

if (!\Bitrix\Main\Loader::includeModule('redsign.kompred'))
{
    \ShowError(Loc::getMessage('RS_KP_KOE_MODULE_NOT_INSTALLED'));
    return;
}

class RedsginKompredOfferEdit extends RedsignKompredOfferShow
{
    public function executeComponent(): void
    {
        if (
            $this->checkModules() &&
            $this->checkPermission() &&
            $this->loadOffer()
        )
        {
            $this->refresh();
            $this->checkActions();
            $this->formatResult();
        }

        $this->formatMessages();
        $this->formatResultErrors();

        $this->includeComponentTemplate();
    }

    /**
     * @return string|null
     */
    public function makeShortLinkAction()
    {
        if (
            $this->checkModules() &&
            $this->checkPermission() &&
            $this->loadOffer() &&
            $this->offer
        ) {
            $fullUrl = $this->offer->getPath($this->arParams['DOWNLOAD_URL']);

            return $this->shortener->make($this->offer, $fullUrl);
        }

        return null;
    }

    protected function checkPermission(): bool
    {
        if (!$this->user->getId())
        {
            $this->errorCollection[] = new Error(
                Loc::getMessage('RS_KP_KOE_ACCESS_DENIED') ?: 'ACCESS_DENIED',
                self::ERROR_NO_ACCESS
            );

            return false;
        }

        return true;
    }

    protected function loadOffer(): bool
    {
        if (parent::loadOffer())
        {
            if (
                $this->user->isAdmin() ||
                $this->offer && $this->user->getId() == $this->offer->getUserId()
            )
            {
                return true;
            }
        }

        $this->errorCollection[] = new Error(
            Loc::getMessage('RS_KP_KOE_OFFER_NOT_FOUND') ?: 'OFFER_NOT_FOUND',
            self::ERROR_OFFER_NOT_FOUND
        );

        return false;
    }

    private function deleteOffer(): void
    {
        if (!$this->offer)
            return;

        $delResult = $this->offer->delete();
        $this->errorCollection->add($delResult->getErrors());

        if ($delResult->isSuccess())
        {
            $this->flashService->success(Loc::getMessage('RS_KP_KOE_OFFER_DELETED') ?: 'OFFER_DELETED');
            \LocalRedirect($this->arParams['LIST_URL']);
        }
    }

    private function checkActions(): void
    {
        if ($this->request->getQuery('del') === 'Y' && check_bitrix_sessid())
        {
            $this->deleteOffer();
        }
    }
}
