$(function () {
  //キャンセルのモーダル
  //予約日・時間・確認文言・閉じるボタン・キャンセルボタン表示
  $('.modal-cancel').on('click', function () {
    $('.js-modal-cancel').fadeIn();

    //日付（表示用とDBに送る用の記述）
    var setting_reserve = $(this).attr('reserve_days');
    //DB
    var hide_setting_reserve = $(this).attr('setting_reserve');

    //部数（表示用とDBに送る用の記述）
    var reservePart = $(this).attr('reserve_part');
    //DB
    var setting_part = $(this).attr('part-int');

    //定義する
    $('.modal-reserve p').text(setting_reserve);
    $('.modal-reserve input').val(hide_setting_reserve);
    $('.modal-reserve-part p').text(reservePart);
    $('.modal-reserve-part input').val(setting_part);

    return false;
  });
  //閉じるボタン
  $('.js-modal-close').on('click', function () {
    $('.js-modal-cancel').fadeOut();
    return false;
  });

});
