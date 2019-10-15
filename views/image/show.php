<div class="block">
    <div id="image-block">
        <div id="image-block-image">
            <img src="http://localhost:8080/public/img/photo/<?= $data['name'] ?>" alt="image1">
            <?php if (Session::get('logged') == $data['author']) { ?>
                <button id="del-user-image" class="del-img-btn"></button>
            <?php } ?>
        </div>
        <div id="image-block-side">
            <div>
                <div id="comment-block">
                </div>
                <form id="comment-form" method="post">
                    <div>
                        <input type="text" name="comment" class="input" />
                        <input type="hidden" name="user" value="<?= Session::get('logged') ?>" />
                        <input type="hidden" name="image" value="<?= $data['name'] ?>" />
                        <input type="hidden" name="author" value="<?= $data['author'] ?>" />
                        <input type="submit" value="Send" class="submit" />
                    </div>
                </form>
            </div>
            <div id="image-block-side-footer">
                <div id="like-bar">
                    <div id="like" class="icon-nav"></div>
                    <span id="countLike"><?= $data['likes']['count'] ?></span>
                    <form id="like-form" method="post">
                        <input type="hidden" name="user" value="<?= Session::get('logged') ?>" />
                        <input type="hidden" name="image" value="<?= $data['name'] ?>" />
                    </form>
                </div>
                <div id="comment-bar">
                    <div id="comment-icon" class="icon-nav"></div>
                    <span id="countComments"><?= $data['comments']['count'] ?></span>
                </div>
                <a id="author-image" href="http://localhost:8080/user/profile/<?= $data['author'] ?>">
                    <?= $data['author'] ?>
                </a>
            </div>
        </div>
    </div>
</div>
<script>

    const likeForm = document.getElementById('like-form');
    const likeButton = document.getElementById('like');
    const commentForm = document.getElementById('comment-form');
    const commentBlock = document.getElementById('comment-block');
    const commentButton = document.getElementById('comment-icon');
    const delUserImage = document.getElementById('del-user-image');
    const image = '<?= $data['name'] ?>';
    const currentUser = '<?= Session::get('logged') ?>';
    const imageHeight = document.getElementById('image-block-image').children[0].height;
    const commentFormHeight = document.getElementById('comment-form').offsetHeight;
    const commentFooter = document.getElementById('image-block-side-footer').offsetHeight;
    commentBlock.style.maxHeight = imageHeight - commentFormHeight - commentFooter + 'px';
    
    fetch('/comment/getCommentsImage/' + image, {
        method: 'GET'
    })
        .then((res) => {
            return res.json();
        })
        .then((comments) => {
            if (!comments || !comments.length) {
                return ;
            }
            displayComments(comments);
        })
        .catch((err) => {
            alert('Error!');
        });

    if (delUserImage) {
        delUserImage.onclick = () => {
            if (!confirm('Are you sure?')) {
                return ;
            }
            fetch('/image/del/' + image, {
                method: 'DELETE'
            })
                .then((res) => {
                    return res.json();
                })
                .then((data) => {
                    if (data.message) {
                        alert(data.message);
                    } else {
                        document.location.href = '/';
                    }
                })
                .catch((err) => {
                    alert('Error');
                });
        };
    }
    

    likeButton.onclick = () => {
        const formData = new FormData(likeForm);

        fetch('/like/submit', {
            method: 'POST',
            body: formData
        })
            .then((res) => {
                return res.json();
            })
            .then((data) => {
                if (data.message) {
                    alert(data.message);
                } else {
                    countLike.innerHTML = Number(countLike.innerHTML) + data.like;
                }
            })
            .catch((err) => {
                alert('Error!');
            });
    };

    commentButton.onclick = () => {
        commentForm.comment.focus();
    };

    commentForm.onsubmit = (event) => {
        event.preventDefault();

        const formData = new FormData(commentForm);

        fetch('/comment/add', {
            method: 'POST',
            body: formData
        })
            .then((res) => {
                return res.json();
            })
            .then((data) => {
                if (data.message) {
                    alert(data.message);
                } else {
                    data.user = commentForm.user.value;
                    // data.text = commentForm.comment.value;

                    commentForm.comment.value = '';
                    commentBlock.appendChild(createComment(data));
                    countComments.innerHTML = Number(countComments.innerHTML) + 1;
                }
            })
            .catch((err) => {
                alert('Error!');
            });
    };

    function createComment(data) {
        const comment = document.createElement('div');
        comment.setAttribute('cmt-id', data.id);
        comment.classList.add('comment');
        
        const commentUserDiv = document.createElement('div');
        const commentUser = document.createElement('a');
        commentUser.href = 'http://localhost:8080/user/profile/' + data.user
        commentUser.classList.add('comment-user');
        commentUser.innerHTML = data.user;
        commentUserDiv.appendChild(commentUser);
        comment.appendChild(commentUserDiv);

        const commentText = document.createElement('span');
        commentText.classList.add('comment-text');
        commentText.innerHTML = data.text;
        comment.appendChild(commentText);

        const commentDate = document.createElement('div');
        commentDate.classList.add('comment-date');
        commentDate.innerHTML = data.date;
        comment.appendChild(commentDate);

        if (currentUser == data.user) {
            const delButton = document.createElement('button');
            delButton.classList.add('del-img-btn');
            comment.appendChild(delButton);
            delButton.addEventListener('click', (event) => {
                    if (!confirm('Are you sure?')) {
                        return ;
                    }
                    const cmtId = event.target.parentElement.getAttribute('cmt-id');
                    fetch('/comment/del/' + cmtId, {
                        method: 'DELETE'
                    })
                        .then((res) => {
                            return res.json();
                        })
                        .then((data) => {
                            if (data.message) {
                                alert(data.message);
                            } else {
                                event.target.parentElement.remove();
                                countComments.innerHTML = Number(countComments.innerHTML) - 1;
                            }
                        })
                        .catch((err) => {
                            alert('Error');
                        });
                });
        }

        return comment;
    };

    function displayComments(data) {
        data.forEach((item) => {
            commentBlock.appendChild(createComment(item));
        });
    };

</script>
