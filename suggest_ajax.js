$(function () {
    // 「#submit」をクリックしたとき
    $('#submit').click(function () {
        // Ajax通信を開始する
        $.ajax({
            url: 'suggest_json.php',
            type: 'post', // getかpostを指定(デフォルトは前者)
            dataType: 'json', // 「json」を指定するとresponseがJSONとしてパースされたオブジェクトになる
            data: { // 送信データを指定(getの場合は自動的にurlの後ろにクエリとして付加される)
                message: $('#massage').val()
            }
        })
        // ・ステータスコードは正常で、dataTypeで定義したようにパース出来たとき
        .done(function (response) {
            $('#list').append(response.html);
        })
        // ・サーバからステータスコード400以上が返ってきたとき
        // ・ステータスコードは正常だが、dataTypeで定義したようにパース出来なかったとき
        // ・通信に失敗したとき
        .fail(function () {
            $('#list').append('<p>失敗です・・・</p>');
        });
    });

    $('[name=select]').click(function () {
        var txt = $('[name=select] option:selected').text();
        $.ajax({
            url: 'suggest.php',
            type: 'post', // getかpostを指定(デフォルトは前者)
            dataType: 'html', // 「json」を指定するとresponseがJSONとしてパースされたオブジェクトになる
            data: { // 送信データを指定(getの場合は自動的にurlの後ろにクエリとして付加される)
                text: txt
            }
        })
        .done(function (response) {
            $('#sentence').append(response);
        })
        .fail(function () {
            $('#sentence').append('<p>失敗です・・・</p>');
        });
    });
});