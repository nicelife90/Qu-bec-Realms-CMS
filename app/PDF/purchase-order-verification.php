<?php
/**
 * Copyright (C) 2014 - 2017 Threenity CMS - All Rights Reserved
 * Unauthorized copying of this file, via any medium is strictly prohibited
 * Proprietary  and confidential
 * Written by : nicelife90 <yanicklafontaine@gmail.com>
 * Last edit : 2018
 *
 *
 */

require $_SERVER['DOCUMENT_ROOT'] . '/app/Helpers/Loader.php';

use Dompdf\Dompdf;
use ThreenityCMS\Helpers\Security;
use ThreenityCMS\Helpers\Path;
use ThreenityCMS\Helpers\Request;
use ThreenityCMS\Helpers\Utils;
use ThreenityCMS\Models\Ogasys\AchBonAchDetModel;
use ThreenityCMS\Models\Ogasys\AchBonAchEntModel;
use ThreenityCMS\Repositories\Product;
use ThreenityCMS\Models\Ogasys\AchBonAchDetProvModel;

/**
 * Validate access
 */
Security::havePdfAccess();


/**
 * Data
 */
$po_serial = Request::get("po");
$header = AchBonAchEntModel::getPurchaseOrderBySerial($po_serial);
$detail = AchBonAchDetModel::getPurchaseOrderWithProvisionBySerial($po_serial);
$provision = AchBonAchDetProvModel::getProvisionDetailByPurchaseOrderSerial($po_serial);


/**
 * Prepare template parsing using Smarty
 */
$smarty = new Smarty();
$smarty->setTemplateDir($_SERVER['DOCUMENT_ROOT'] . '/app/PDF/Templates/');

//PREPARE ITEMS
$products = null;
foreach ($detail as $row) {

    $p = new Product($row->Produit);

    if (file_exists($_SERVER['DOCUMENT_ROOT'] . 'dist/img/products/' . strtoupper($p->getProduct()) . '.jpg')) {
        $img = '../../dist/img/products/' . strtoupper($p->getProduct()) . '.jpg';
    } else {
        $img = '../../dist/img/no_image.jpg';
    }

    $products[] = [
        "produit" => $p->getProduct(),
        "description" => $p->getDescription(),
        "commandee" => Utils::nf($row->CmQteCommandee, 0),
        "recue" => Utils::nf($row->CmQteRecue, 0),
        "cout_us" => Utils::nf($row->CmPrixUnitaire),
        "cout_cad" => Utils::nf($p->getAverageCost(), 3),
        "cout_prov" => Utils::nf($row->PrixProv, 3),
        "prix" => $p->getPrice(),
        "eco" => $p->getEhfGroupCode(),
        "eco_desc" => $p->getEhfGroupDescription(),
        "epaiseur" => Utils::nf($p->getEpaisseur()),
        "largeur" => Utils::nf($p->getLargeur()),
        "longeur" => Utils::nf($p->getLongueur()),
        "poids" => Utils::nf($p->getPoids()),
        "volume" => Utils::nf($p->getVolume()),
        "upc" => $p->getUpc(),
        "master" => $p->getMasterPack(),
        "inner" => $p->getInnerPack(),
        "plancher" => $p->getInStore() == true ? "Oui" : "Non",
        "plancher_qte" => Utils::nf($p->getInStoreQuantity(), 0),
        "web" => "N/D",
        "img" => $img,
    ];

}


/**
 * Assign value to this template
 */

//CSS
$smarty->assign('root', Path::root());

//DOCUMENT TITLE + NUMBER
$smarty->assign('dtitle', 'Bon d\'achat');
$smarty->assign('dnumber', $header->NoBonAch);

//SUPPLIER
$smarty->assign('vname', $header->NomClient);
$smarty->assign('vaddress', $header->AdrClient1);
$smarty->assign('vcity', $header->AdrClient2);
$smarty->assign('vstate', $header->AdrClient3);
$smarty->assign('vpostal', $header->CodePClient);
$smarty->assign('vphone', Utils::pnf($header->TelClient));
$smarty->assign('vfax', Utils::pnf($header->FaxClient));

//CUSTOMER
$smarty->assign('cname', $header->ExpNom);
$smarty->assign('caddress', $header->ExpAdr1);
$smarty->assign('ccity', $header->ExpAdr2);
$smarty->assign('cstate', $header->ExpAdr3);
$smarty->assign('cpostal', $header->ExpCodeP);

//PO
$smarty->assign('po_supplier', $header->NoFourn);
$smarty->assign('po_date', Utils::dateFromTimeStamp('d/m/Y', $header->DateEmis));
$smarty->assign('po_require_date', Utils::dateFromTimeStamp('d/m/Y', $header->DateReq));
$smarty->assign('po_by', $header->Acheteur);
$smarty->assign('provision', json_decode(json_encode($provision), true));

//ITEMS
$smarty->assign('po_items', $products);

//FOOTER
$smarty->assign('date', date('d/m/Y H:m:s'));

/**
 * Parse this template
 */
$html = $smarty->fetch('purchase-order-verification.tpl');


/**
 * Generate pdf form html and open in browser
 */
$dompdf = new Dompdf();
$dompdf->loadHtml($html);
$dompdf->setPaper('legal', 'landscape');
$dompdf->render();
$dompdf->stream(uniqid('po_verification_', true), ['Attachment' => 0]);
?>