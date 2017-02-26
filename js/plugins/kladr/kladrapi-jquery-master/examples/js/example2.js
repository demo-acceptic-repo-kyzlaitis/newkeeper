(function($){
    $(function() {
        var city = $( '[name="city"]' );
        var street = $( '[name="street"]' );
        
        street.kladr({
            token: '51dfe5d42fb2b43e3300006e',
            key: '86a2c2a06f1b2451a87d05512cc2c3edfdf41969',
            type: $.ui.kladrObjectType.STREET,
            parentType: $.ui.kladrObjectType.CITY,
            parentId: city.val()
        });
        
        city.change(function(){
            street.kladr( 'option', { parentType: $.ui.kladrObjectType.CITY, parentId: city.val() } );
        });
    });
})(jQuery);