<!-- Template de comentários -->
<div class="col-md-12 review">
    <div class="row">
        <!-- icone de imagem do user -->
        <div class="col-md-1">
            <div class="profile-image-container review-imagem" style="background-image: url('<?= $BASE_URL ?>image/users/user.png');"></div>
        </div>

        <div class="col-md-9 author-details-container">
            <h4 class="author-name"><a href="">Felippe</a></h4>
            <p><i class="fas fa-star"></i> <?=$review->rating?></p>
        </div>

        <div class="col-md-12">
            <p class="comment-title">Comentário:</p>
            <p><?=$review->id?></p>
            <p><?=$review->review?></p>
        </div>
    </div>
</div>