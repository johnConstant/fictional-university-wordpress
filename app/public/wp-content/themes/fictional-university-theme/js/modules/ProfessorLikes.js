import $ from 'jquery';

class Like {
    constructor(){

        if (document.querySelector(".like-box")) {
            this.likeBtn = document.querySelector('.like-box');
            this.events()
          }
    }

    events(){
        this.likeBtn.addEventListener('click', this.clickDispatcher.bind(this));
    }

    clickDispatcher(event){
        let currentLikeBox = event.target
        while (!currentLikeBox.classList.contains("like-box")) {
            currentLikeBox = currentLikeBox.parentElement
          }

        if(this.likeBtn.dataset.exists === 'yes'){
            this.deleteLike(currentLikeBox);
        }else{
            this.addLike(currentLikeBox);
        }
    }

    addLike(currentLikeBox){
        $.ajax({
            beforeSend: (xhr) => {
                xhr.setRequestHeader('X-WP-Nonce', universityData.nonce);
            },
            url: universityData.root_url + '/wp-json/university/v1/manageLike',
            type: 'POST',
            // the data property is equivalent to adding the value as a parameter to the URL
            data: {
                "professorId": currentLikeBox.dataset.professor 
            },
            success: (response)=> {
                console.log(response);
                currentLikeBox.dataset.exists = 'yes';
                let likeCount = parseInt(currentLikeBox.querySelector(".like-count").innerHTML, 10)
                likeCount++;
                currentLikeBox.querySelector(".like-count").innerHTML = likeCount;
                currentLikeBox.dataset.like = response;
            },
            error: (response)=> {
                console.log(response)
            }
        });
    }

    deleteLike(currentLikeBox){
        $.ajax({
            beforeSend: (xhr) => {
                xhr.setRequestHeader('X-WP-Nonce', universityData.nonce);
            },
            url: universityData.root_url + '/wp-json/university/v1/manageLike',
            // the data property is equivalent to adding the value as a parameter to the URL
            data: {
                "like": currentLikeBox.dataset.like 
            },
            type: 'DELETE',
            success: (response)=> {
                console.log(response);
                currentLikeBox.dataset.exists = 'no';
                let likeCount = parseInt(currentLikeBox.querySelector(".like-count").innerHTML, 10)
                likeCount--;
                currentLikeBox.querySelector(".like-count").innerHTML = likeCount;
                currentLikeBox.dataset.like = '';
            },
            error: (response)=> {
                console.log(response)
            }
        });       
    }
}

export default Like