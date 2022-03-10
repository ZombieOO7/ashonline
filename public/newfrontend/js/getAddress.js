$(function () {
    $.validator.addMethod("postcodeUK", function (value, element) {
        return this.optional(element) || /^(([gG][iI][rR] {0,}0[aA]{2})|((([a-pr-uwyzA-PR-UWYZ][a-hk-yA-HK-Y]?[0-9][0-9]?)|(([a-pr-uwyzA-PR-UWYZ][0-9][a-hjkstuwA-HJKSTUW])|([a-pr-uwyzA-PR-UWYZ][a-hk-yA-HK-Y][0-9][abehmnprv-yABEHMNPRV-Y]))) {0,}[0-9][abd-hjlnp-uw-zABD-HJLNP-UW-Z]{2}))$/i.test(value);
    }, "Please specify a valid Postcode");
});
$('#countryId').on('change',function(){
    if($('#countryId :selected').text() == 'United Kingdom'){
        $('#postcode').attr('readonly',false);
    }else{
        $('#postcode').attr('readonly',true);
        $('#postcode').val('');
    }
})
$.ui.autocomplete.prototype._renderItem = function (ul, item) {
    var re = new RegExp($.trim(this.term.toLowerCase()));
    var t = item.label.replace(re, "<span style='font-weight:600;color:#5C5C5C;'>" + $.trim(this.term.toLowerCase()) +"</span>");
    return $("<li></li>")
        .data("item.autocomplete", item)
        .append("<a class='' data-id="+item.id+" data-url="+item.url+">" + item.label + "</a>")
        .appendTo(ul);
};
var data = [
    "ActionScript",
    "AppleScript",
    "Asp",
    "BASIC",
    "C",
    "C++",
    "Clojure",
    "COBOL",
    "ColdFusion",
    "Erlang",
    "Fortran",
    "Groovy",
    "Haskell",
    "Java",
    "JavaScript",
    "Lisp",
    "Perl",
    "PHP",
    "Python",
    "Ruby",
    "Scala",
    "Scheme"
];
$("#postcode").autocomplete({
    minLength:7,
    validationRules:{
        postcodeUK:true,
    },
    validationMessage: {
        postcodeUK:'Please specify a valid Postcode',
    },
    source: function(request, response){
        $.ajax({
            url:'https://api.getaddress.io/autocomplete/'+$("#postcode").val()+'?api-key='+$addressKey,
            method:'GET',
            global:false,
            success:function(result){
                data=[];
                $.each(result.suggestions,function(index,value){
                    data.label=value.address;
                    data.id=value.id;
                    data.url=value.url;
                    data.postcode=value.postcode;
                    data.push(data);
                })
                response( data );
            }
        });
    },
    select: function (event, ui) {
        $.ajax({
            url: "https://api.getAddress.io/get/"+ui.item.id+"?api-key="+$addressKey,
            method: "GET",
            global:false,
            success:function(result){
                setTimeout(function(){
                    $('#address').val(result.line_1);
                    $('#address2').val(result.line_2);
                    $('#city').val(result.town_or_city);
                    // $('#county').val(result.county);
                    $('#postcode').val(result.postcode);
                },200);
            }
        })
    }
});
