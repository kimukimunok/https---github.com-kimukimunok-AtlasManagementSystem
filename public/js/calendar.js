$(function () {
  //キャンセルのモーダル
    //   予約日・時間・確認文言・閉じるボタン・キャンセルボタン表示
    // click functionでボタン押したときの動作を決める。
  $('.modal-cancel').on('click', function () {
    $('.js-modal-cancel').fadeIn();

      //   情報の取得(予約日と予約部)
      // 予約日=$reserveDay 予約時間=$reservePart
      var reserveDay = $(this).attr('reserveDays');
      var reservePart = $(this).attr('reserveParts');

    //   変数定義
    $('.modal_reserveDay').text(reserveDay);
      $('.modal_reservePart').val(reservePart);
       return false;
  });
  //閉じるボタン
  $('.js-modal-close').on('click', function () {
    $('.js-modal-cancel').fadeOut();
    return false;
  });

});
