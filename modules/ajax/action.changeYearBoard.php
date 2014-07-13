<?php
// set type, volume, power,
$objResponse = new xajaxResponse();
$objResponse->addScript('var years = document.getElementById("yearId");');
$objResponse->addScript('years.disabled = false;');
$objResponse->addScript("document.getElementById('volumeId').value='';");
$objResponse->addScript("document.getElementById('powerId').value ='';");
$objResponse->addScript("document.getElementById('kppId').value='';");
$objResponse->addScript("document.getElementById('acpro_inp4').value='';");
$objResponse->addScript("document.getElementById('acpro_inp7').value='';");

$objResponse->addScript("document.getElementById('kapRemontId').value='';");
$objResponse->addScript("document.getElementById('kapRemontId').disabled = false;");

$objResponse->addScript("document.getElementById('placesId').value='';");
$objResponse->addScript("document.getElementById('placesId').disabled = false;");

$objResponse->addScript("document.getElementById('dveriId').value='';");
$objResponse->addScript("document.getElementById('dveriId').disabled = false;");

$objResponse->addScript('var kppId = document.getElementById("kppId");');
$objResponse->addScript('kppId.length = 0;');
$objResponse->addScript('kppId.disabled = false;');
$objResponse->addScript('kppId.options.add(new Option("[Выберите]", "0"));');

$objResponse->addScript('var kppVidId = document.getElementById("kppVidId");');
$objResponse->addScript('kppVidId.length = 0;');
$objResponse->addScript('kppVidId.disabled = false;');
$objResponse->addScript('kppVidId.options.add(new Option("[Выберите вид коробки]", "0"));');

$objResponse->addScript('var kppStupId = document.getElementById("kppStupId");');
$objResponse->addScript('kppStupId.length = 0;');
$objResponse->addScript('kppStupId.disabled = false;');
$objResponse->addScript('kppStupId.options.add(new Option("[Выберите количество ступеней]", "0"));');

$objResponse->addScript('var typeId = document.getElementById("typeId");');
$objResponse->addScript('typeId.length = 0;');
$objResponse->addScript('typeId.disabled = false;');
$objResponse->addScript('typeId.options.add(new Option("[Выберите тип]", "0"));');

$objResponse->addScript('var privodId = document.getElementById("privodId");');
$objResponse->addScript('privodId.length = 0;');
$objResponse->addScript('privodId.disabled = false;');
$objResponse->addScript('privodId.options.add(new Option("[Выберите тип привода]", "0"));');

$objResponse->addScript('var kuzovId = document.getElementById("kuzovId");');
$objResponse->addScript('kuzovId.length = 0;');
$objResponse->addScript('kuzovId.disabled = false;');
$objResponse->addScript('kuzovId.options.add(new Option("[Выберите тип кузова]", "0"));');

$objResponse->addScript('var colorId = document.getElementById("colorId");');
$objResponse->addScript('colorId.length = 0;');
$objResponse->addScript('colorId.disabled = false;');
$objResponse->addScript('colorId.options.add(new Option("[Выберите цвет]", "0"));');

// $objResponse->addAlert (" alert (document.getElementById('isYear').value);" );
// $objResponse->addAlert("status = " . $yearStatus . " year = " . $yearId);
if ($yearId != 0 && $yearStatus == 'false') {
  //$objResponse->addAlert($yearStatus);
  $item = new Socnet_Catalog_Model_Property_Item();
  $item->setIdModelGod($yearId); // == $idModelGod;

  // модификация
  $acpro_inp4 = $item->getPropertyValueById(2);
  $objResponse->addScript("document.getElementById('acpro_inp4').value = '$acpro_inp4';");

  // Пробег
  $acpro_inp13 = $item->getPropertyValueById(13);
  $objResponse->addScript("document.getElementById('acpro_inp7').value = '$acpro_inp13';");

  // объем двигателя
  $volume = $item->getPropertyValueById(6);
  $objResponse->addScript("document.getElementById('volumeId').value = '$volume';");

  // мощность двигателя.
  $horsePower = $item->getPropertyValueById(7);
  $objResponse->addScript("document.getElementById('powerId').value  = '$horsePower';");

  // Капитальный ремонт.
  $kapRemont = $item->getPropertyValueById(14);
  $objResponse->addScript("document.getElementById('kapRemontId').value  = '$kapRemont';");

  // мест
  $places = $item->getPropertyValueById(17);
  $objResponse->addScript("document.getElementById('placesId').value  = '$places';");

  // двери
  $dveri = $item->getPropertyValueById(18);
  $objResponse->addScript("document.getElementById('dveriId').value  = '$dveri';");

  // КПП
  foreach ($item->getPropertyValueListName(10, $item->getId(), true) as $_id => $_name) {
    $objResponse->addScript('kppId.options.add(new Option("' . $_name . '","' . $_id . '"));');
  }

  // Вид автоматической КПП
  foreach ($item->getPropertyValueListName(11, $item->getId(), true) as $_id => $_name) {
    $objResponse->addScript('kppVidId.options.add(new Option("' . $_name . '","' . $_id . '"));');
  }

  // Кол-во ступеней КПП
  foreach ($item->getPropertyValueListName(12, $item->getId(), true) as $_id => $_name) {
    $objResponse->addScript('kppStupId.options.add(new Option("' . $_name . '","' . $_id . '"));');
  }

  // Тип двигла
  foreach ($item->getPropertyValueListName(5, $item->getId(), true) as $_id => $_name) {
    $objResponse->addScript('typeId.options.add(new Option("' . $_name . '","' . $_id . '"));');
  }

  // Привод
  foreach ($item->getPropertyValueListName(19, $item->getId(), true) as $_id => $_name) {
    $objResponse->addScript('privodId.options.add(new Option("' . $_name . '","' . $_id . '"));');
  }

  // Тип кузова
  foreach ($item->getPropertyValueListName(16, $item->getId(), true) as $_id => $_name) {
    $objResponse->addScript('kuzovId.options.add(new Option("' . $_name . '","' . $_id . '"));');
  }

  // Цвет
  foreach ($item->getPropertyValueListName(19, $item->getId(), true) as $_id => $_name) {
    $objResponse->addScript('colorId.options.add(new Option("' . $_name . '","' . $_id . '"));');
  }

}
return $objResponse;
?>