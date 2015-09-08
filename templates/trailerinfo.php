<h3 class="test-content"></h3>

<script type="text/javascript">
(function($){

var getUrlParameter = function getUrlParameter(sParam) {
    var sPageURL = decodeURIComponent(window.location.search.substring(1)),
        sURLVariables = sPageURL.split('&'),
        sParameterName,
        i;

    for (i = 0; i < sURLVariables.length; i++) {
        sParameterName = sURLVariables[i].split('=');

        if (sParameterName[0] === sParam) {
            return sParameterName[1] === undefined ? true : sParameterName[1];
        }
    }
};


var param = getUrlParameter('series');
console.log(param);
var data_series = param + '-series';
console.log(data_series);
var series = getUrlParameter(data_series);
console.log(series);
$( document ).ready(function() {

$.ajax({
    url: "/wp-content/themes/doolittle/trailers.json",
    type: "GET",
    dataType: 'json',
    contentType: 'application/json; charset=utf-8',
    success: function(data) {
		var trailer = data.trailers[series];
		$('.test-content').append(trailer.title);
    },
    error : function(jqXHR, textStatus, errorThrown) {
        console.error(errorThrown);
    },

    
});



});

})(jQuery);
</script>