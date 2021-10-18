Array.from(document.getElementsByClassName("heart")).forEach(item => {
    item.addEventListener('click', function() {
        console.log(this.parentElement.getAttribute("href").replace("javascript:void(0)/",""));
        this.classList.toggle("fa-heart");
        this.classList.toggle("fa-heart-o");
        axios.post(heart,{
            
            id : this.parentElement.getAttribute("href").replace("javascript:void(0)/","")
        })
        .then(function(response){
            console.log(response.data);
        });
    });
});