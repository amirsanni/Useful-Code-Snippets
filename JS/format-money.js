function formatMoney(amount){
    //use Intl.NumberFormat() if supported by browser, else use the regExp
    return new Intl.NumberFormat().format(amount) || amount.toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, '$1,');
}
