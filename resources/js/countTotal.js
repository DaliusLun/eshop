prices = document.getElementsByClassName('itemtotalprice');
sum = 0;
for (let i = 0; i < prices.length; i++) {
    sum += parseInt(document.getElementsByClassName('itemtotalprice')[i].value);
    
}

console.log(sum);
console.log(document.getElementsByClassName('total'));
document.getElementsByClassName('total')[0].innerHTML = sum;