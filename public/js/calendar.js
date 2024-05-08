$(function () {
  //キャンセルのモーダル
    //   予約日・時間・確認文言・閉じるボタン・キャンセルボタン表示
    // click functionでボタン押したときの動作を決める。
  $('.modal-cancel').on('click', function () {
    $('.js-modal-cancel').fadeIn();

      //  変数定義
      // これが最終的に決まった名前→予約日 = $setting_reserve 予約時間 = $reservePart

    //   ミスvar reserveDays = $(this).attr('setting_reserve');viewで予約日のデータを受け取った際、value=で予約日の情報を取得していたからval();で表示することとなる。
      var reserveDays = $(this).val();
      var reserveParts = $(this).attr('reservePart');

      //モーダルに送る情報
      //  クラスをbladeと合わせること あとはval 以外で送るようにする。
      //   modal_reserveDay modal_reservePart
      //   reserveDays　reserveParts
      //   IDを#～で指定。
    $('.modal_reserve #reserveDays').val(reserveDays);
      $('.modal_reserve #reserveParts ').val(reserveParts);


       return false;
  });
  //閉じる
  $('.js-modal-close').on('click', function () {
    $('.js-modal-cancel').fadeOut();
    return false;
  });

});
