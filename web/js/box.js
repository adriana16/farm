import Vue from 'vue';
import DeleteBoxComponent from './components/DeleteBoxButtonComponent';

$(function() {
    var $collectionHolder = $('div.box-product'),
        boxProduct = $('.box-product')
    ;

    $collectionHolder.data('index', $collectionHolder.find('.box-products').length);

    boxProduct.on('click', '.delete-product', function(e) {
        e.preventDefault();
        $(this).closest('.box-products').remove();
    });

    boxProduct.on('click', '.add-product', function(e) {
        e.preventDefault();
        var $collectionHolder = $('div.box-product'),
            prototype = $collectionHolder.data('prototype'),
            index = $collectionHolder.data('index'),
            newForm = prototype.replace(/__name__/g, index + 1 );

        $collectionHolder.data('index', index + 1);
        $collectionHolder.append(newForm);
    });

});

/**
 * Create a fresh Vue Application instance
 */
var app = new Vue({
    el: '#app',
    data: {
        productName: ''
    },
    components: {
        'delete-box': DeleteBoxComponent
    },
    mounted: function () {
        console.log('doneeeeBox');
    }
});
