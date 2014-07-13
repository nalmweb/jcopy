<?php

class AjaxController extends Socnet_Controller_Action {
  public function __construct(Zend_Controller_Request_Abstract $request, Zend_Controller_Response_Abstract $response, array $invokeArgs = array()) {
    parent::__construct($request, $response, $invokeArgs);
  }

  public function closePopupAction($div_id = "") {
    $xajaxPopup = new xajaxPopup($div_id);
    $response = $xajaxPopup->getClose();
    return $response;
  }

  public function changeCountryAction($countryId = "") {
    include_once('action.changeCountry.php');
    return $objResponse;
  }

  public function changeCityAction($cityId = "") {
    include_once('action.changeCity.php');
    return $objResponse;
  }

  public function changeTrademarkAction($markId = '') {
    include_once('action.changeTrademark.php');
    return $objResponse;
  }

  public function changeTrademarkDetailsAction($markId = "") {
    include_once('action.changeTrademarkDetails.php');
    return $objResponse;
  }

  public function changeTrademarkBoardAction($markId = "", $markName = '') {
    include_once('action.changeTrademarkBoard.php');
    return $objResponse;
  }

// 	public function changeTrademarkBoardAction($cat_id="",$item_id='') {include_once('action.changeTrademarkBoard.php'); return $objResponse;}

  public function changeTrademarkSearchAction($markId = "", $markName = '') {
    include_once('action.changeTrademarkSearch.php');
    return $objResponse;
  }

  //
  public function changeYearAction($yearId = "") {
    include_once('action.changeYear.php');
    return $objResponse;
  }

  public function changeYearBoardAction($yearId = "", $yearStatus = "") {
    include_once('action.changeYearBoard.php');
    return $objResponse;
  }

  public function changeTrademarkOnInviteAction($values = "") {
    include_once('action.changeTrademarkOnInvite.php');
    return $objResponse;
  }

  public function changeModelAction($modelId = "") {
    include_once('action.changeModel.php');
    return $objResponse;
  }

  public function changeModificationAction($modificationId = "") {
    include_once('action.changeModification.php');
    return $objResponse;
  }

  public function changeTypesAction($markId = "") {
    include_once('action.changeTypes.php');
    return $objResponse;
  }

  public function changeOutfitTrademarkAction($markId = "") {
    include_once('action.changeOutfitTrademark.php');
    return $objResponse;
  }

  /**
   * @param: $node_id - if of a commented node
   * @param: $commmet - text
   * @param: $type - if (p) - comment if for level=0; else comment is nested.
   * @param: $m_table Why do we need [$m_table]?-because we have to know where to save comments:[news],[photos],etc
   * @param: $prod_id
   */
  public function addCommentAction($node_id = "", $comment = "", $type = "", $m_table = "", $prod_id = "") {
    include_once('action.addComment.php');
    return $objResponse;
  }

  public function delCommentAction($cid = "", $parent_id = "", $m_table = "") {
    include_once('action.delComment.php');
    return $objResponse;
  }

  public function rateCommentAction($type = "", $cid = "", $sign = "") {
    include_once('action.rateComment.php');
    return $objResponse;
  }

  public function addFriendFormAction($user_id = "") {
    include_once('action.addFriendForm.php');
    return $objResponse;
  }

  public function addFriendDoAction($user_id = "", $message = "") {
    include_once('action.addFriendDo.php');
    return $objResponse;
  }

  public function sendMessageAction($user_id = "") {
    include_once('action.sendMessage.php');
    return $objResponse;
  }

  public function sendMessageDoAction($user_id = "", $subject = "", $message = "") {
    include_once('action.sendMessageDo.php');
    return $objResponse;
  }

  //
  public function checkNicknameAction($nick = "") {
    include_once('action.checkNickname.php');
    return $objResponse;
  }

  //
  /**
   *  universal function for all types of photos.
   * @param: $table_id - a number, represent a table name.
   * @param: $item_id
   * @param: $photo_id
   */
  public function delPhotoAction($table_id = "", $item_id = "", $photo_id = "") {
    include_once('action.delPhoto.php');
    return $objResponse;
  }

  /**
   *  universal function for all types of photos.
   * @param: $table_id - a number, represent a table name.
   * @param: $item_id
   * @param: $photo_id
   * @param: category id used in board.
   */
  public function changePhotoDialogAction($photos_type_id = "", $item_id = "", $photo_id = "", $cat_id = "") {
    include_once('action.changePhotoDialog.php');
    return $objResponse;
  }

  public function uploadPhotoAction() {
    include_once('action.uploadPhoto.php');
  }

  // meeting:
  public function unsubscribeMeetingAction($meeting_id = "") {
    include_once('action.unsubscribeMeeting.php');
    return $objResponse;
  }

  public function changeAdStatusAction($cat_id = "", $item_id = "", $status = "") {
    include_once ('action.changeAdStatus.php');
    return $objResponse;
  }

  public function changeStolenAction($item_id = "") {
    include_once ('action.changeStolen.php');
    return $objResponse;
  }

  public function noRouteAction() {
    $this->_redirect('/');
  }

}