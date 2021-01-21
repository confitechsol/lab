
// Libs ---------------------
window.Chart = require('chart.js');


// Setup ---------------------
$.ajaxSetup({
    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
});



// Utilities ============================
require('./utils/confirm');
require('./utils/action-delete');
require('./utils/conditional-show-hide');
require('./utils/prop-enable-disable');
require('./utils/loading');
require('./utils/number-format');



// Components ============================
require('./components/pagination-bs4alpha');
require('./components/requisition-cart');
require('./components/po-requisition-cart');
require('./components/issue-cart');
require('./components/central-items');
require('./components/item-batch');
require('./components/received-batch');
require('./components/shipment-upload');
require('./components/chart');
