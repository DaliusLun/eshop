Array.from(document.getElementsByClassName("basket")).forEach(item => {
    item.addEventListener('click', function () {
        this.classList.add("btn-success");
            this.innerHTML = "Prekė krepšelyje ✓";
        input = "1";
        if (document.getElementsByClassName("input-group-field").length > 0) {
            input = document.getElementsByClassName("input-group-field")[0].value;
        }
        for (let index = 0; index < input; index++) {
            axios.post(basket,{
                id : this.parentElement.getAttribute("href").replace("javascript:void(0)/","")
            })
            .then(function(response){
                console.log(response.data);
            });
        }
    });
});