function onClickBtnLike(event){
    event.preventDefault();
    const url = this.href;
    const spanCount = this.querySelector('span.js-likes');
    const icone = this.querySelector('i');

    axios.get(url).then(function(response){
        spanCount.textContent = response.data.likes;
        if(icone.classList.contains('fa-solid')){
            icone.classList.replace('fa-solid', 'fa-regular');
        }
        else{
            icone.classList.replace('fa-regular', 'fa-solid');
        }
    }).catch(function(error){
        if(error.response.status === 403){
            window.alert("Vous devez être connecté pour pouvoir liker.")
        }
        else{
            window.alert("Une erreur s'est produite, Réessayez plus tard.")
        }
    })
}

document.querySelectorAll('a.js-like-link').forEach(function(link){
    link.addEventListener('click', onClickBtnLike);
})