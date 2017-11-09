$(function(){

    var getUrlParameter = function getUrlParameter(sParam) {
        var sPageURL       = decodeURIComponent(window.location.search.substring(1));
        var sURLVariables  = sPageURL.split('&');
        var sParameterName = '';
        for (var i = 0; i < sURLVariables.length; i++) {
            sParameterName = sURLVariables[i].split('=');

            if (sParameterName[0] === sParam) {
                return sParameterName[1] === undefined ? true : sParameterName[1];
            }
        }
    };

    $(".navbar-select").change(function (){
        var value = $(this).val();
        var name = $(this).attr('name');
        var parameters = {};
        var sPageURL       = decodeURIComponent(window.location.search.substring(1));
        var flag = false;
        if(sPageURL) {
            var sURLVariables = sPageURL.split('&');
            for (var i = 0; i < sURLVariables.length; i++) {
                var params = sURLVariables[i].split('=');
                //[name, value]
                if (params[0] == name) {
                    flag = true;
                    params[1] = value;
                }
                if(params[0] == 'page'){
                    params[1] = 1;
                }
                parameters[params[0]] = params[1];
            }
            if(!flag){
                parameters[name] = value;
            }

        }else{
            parameters['page'] = 1;
            parameters[name] = value;
        }
        sendParams(parameters);
    });

    function sendParams(params){
        url_redirect({
            url: "home",
            method: "get",
            data: params
        });
    }

    function url_redirect(options){
        var $form = $("<form />");

        $form.attr("action",options.url);
        $form.attr("method",options.method);

        for (var data in options.data)
            $form.append('<input type="hidden" name="'+data+'" value="'+options.data[data]+'" />');

        $("body").append($form);
        $form.submit();
    }
});