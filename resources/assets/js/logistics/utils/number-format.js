Number.prototype.format = function( prefix = '£' ){
    return prefix + this.toFixed(2).replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')
};