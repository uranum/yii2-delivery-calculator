
function calculateCourier(cart, min, max, delivId, areas){
    var area = $('#areas').val();
    var price = $('#deliv-price');
    var cont = $('[data-delivery=' + delivId + ']');

    if(cart > 5000){
        price.text('бесплатно');
        cont.attr('data-delivery-currentCost', 0);

    } else if(cart > 2000){

        if(areas.nullAfter2000.indexOf(area) >= 0){
            price.text('бесплатно');
            cont.attr('data-delivery-currentCost', 0);
        } else {
            price.text(min);
            cont.attr('data-delivery-currentCost', min);
        }

    } else {

        if(areas.nullBefore2000.indexOf(area) >= 0){
            price.text('бесплатно');
            cont.attr('data-delivery-currentCost', 0);
        } else if(areas.minBefore2000.indexOf(area) >= 0) {
            price.text(min);
            cont.attr('data-delivery-currentCost', min);
        } else {
            price.text(max);
            cont.attr('data-delivery-currentCost', max);
        }
    }
}