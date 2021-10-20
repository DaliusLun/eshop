prices = document.getElementsByClassName('itemtotalprice');
sum = 0;
for (let i = 0; i < prices.length; i++) {
    sum += parseInt(document.getElementsByClassName('itemtotalprice')[i].value);
}
document.getElementsByClassName('total')[0].innerHTML = sum;