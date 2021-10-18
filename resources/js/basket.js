
Array.from(document.getElementsByClassName("basket")).forEach(item => {
    
    item.addEventListener('click', function () {
        console.log(this.parentElement.getAttribute("href").replace("javascript:void(0)/",""));
        this.classList.toggle("btn-success");
        if (this.innerHTML.includes("Prekė krepšelyje")) {
            this.innerHTML = "Pridėti į krepšelį";
        } else {
            this.innerHTML = "Prekė krepšelyje ✓";
        }
        ;
        axios.post(basket,{
            id : this.parentElement.getAttribute("href").replace("javascript:void(0)/","")
        })
        .then(function(response){
            console.log(response.data);
        });
    });
});