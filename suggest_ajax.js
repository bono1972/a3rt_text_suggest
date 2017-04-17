$(function () {
    var list_head;
    // 「#submit」をクリックしたとき
    $('#submit').on('click', function () {
        // Ajax通信を開始する
        $.ajax({
            url: 'suggest.php',
            type: 'post', // getかpostを指定(デフォルトは前者)
            dataType: 'json', // 「json」を指定するとresponseがJSONとしてパースされたオブジェクトになる
            data: { // 送信データを指定(getの場合は自動的にurlの後ろにクエリとして付加される)
                message: $('#massage').val()
            }
        })
        // ・ステータスコードは正常で、dataTypeで定義したようにパース出来たとき
        .done(function (response) {
            list_head = response.text;
            $('#list').empty();
            if (!list_head[0]) { //入力チェック
                $('#list').append("文字を入力してください。");
            } else {
                $('#list').append("<p>下記選択肢より続く句を選択してください。</p>");
                $('#list').append(response.html);
            }
        })
        // ・サーバからステータスコード400以上が返ってきたとき
        // ・ステータスコードは正常だが、dataTypeで定義したようにパース出来なかったとき
        // ・通信に失敗したとき
        .fail(function () {
            $('#list').append('<p>失敗です・・・</p>');
        });
    });
    //後から追加されたセレクトボックスに対してクリック出来る様にする
    $(document).on('click','[name=select]',function () {
        $.ajax({
            url: 'answer.php',
            type: 'post',
            dataType: 'html',
            data: {
                text: $('[name=select] option:selected').text(),
                listhead: list_head
            }
        })
        .done(function (response) {
            if (!list_head[0]) { //入力チェック
                $('#list').empty();
                $('#list').append("文字を入力してください。");
            } else {
                $('#answer').append(response);
                $('#massage').val(""); //入力テキストをクリア
                list_head ="";
                $('#delete').show();
            }
        })
        .fail(function () {
            $('#answer').append('<p>失敗です・・・</p>');
        });
    });
    //サジェストされたテキストをクリア
    $('#delete').on('click', function () {
        $('#answer').empty();
        $('#list').empty();
        $('#delete').hide();
    })
});