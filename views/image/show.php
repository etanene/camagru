<div class="card">
    <img src="http://localhost:8080/public/img/photo/<?= $data['name'] ?>" alt="image1">
    <div id="like-bar">
        <div id="like" class="icon-nav"></div>
        <span id="countLike"><?= $data['likes']['countLikes'] ?></span>
        <form id="like-form" method="post">
            <input type="hidden" name="user" value="<?= Session::get('logged') ?>" />
            <input type="hidden" name="image" value="<?= $data['name'] ?>" />
        </form>
    </div>
    <div id="comment-block">
        <?php if (isset($data['comments'])) { 
            foreach ($data['comments'] as $comment) { ?>
            <div class="comment">
                <div class="comment-user"><?= $comment['user'] ?></div>
                <div class="comment-text"><?= $comment['text'] ?></div>
                <div class="comment-date"><?= $comment['date'] ?></div>
            </div>
        <?php }
        } ?>
    </div>
    <form id="comment-form" method="post">
        <div>
            <input type="text" name="comment" class="input" />
            <input type="hidden" name="user" value="<?= Session::get('logged') ?>" />
            <input type="hidden" name="image" value="<?= $data['name'] ?>" />
            <input type="hidden" name="author" value="<?= $data['author'] ?>" />
            <input type="submit" value="Send" />
        </div>
    </form>
</div>
<script>

    const likeForm = document.getElementById('like-form');
    const likeButton = document.getElementById('like');

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

    const commentForm = document.getElementById('comment-form');
    const commentBlock = document.getElementById('comment-block');
    
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
                    data.text = commentForm.comment.value;

                    commentBlock.appendChild(createComment(data));
                }
            })
            // .catch((err) => {
            //     alert('Error!');
            // });
    };

    function createComment(data) {
        const comment = document.createElement('div');
        comment.classList.add('comment');
        
        const commentUser = document.createElement('div');
        commentUser.classList.add('comment-user');
        commentUser.innerHTML = data.user;
        comment.appendChild(commentUser);

        const commentText = document.createElement('div');
        commentText.classList.add('comment-text');
        commentText.innerHTML = data.text;
        comment.appendChild(commentText);

        const commentDate = document.createElement('div');
        commentDate.classList.add('comment-date');
        commentDate.innerHTML = data.date;
        comment.appendChild(commentDate);

        return comment;
    };
</script>
