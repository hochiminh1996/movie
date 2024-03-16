<!-- Template de comentários -->

<?php 
    // pegando o nome completo do user
    $userModel = new User();
    $fullName = $userModel->getFullName($review->user);

    // se o usuário não tiver imagem no banco
    if($review->user->image == ""){
        $review->user->image = "user.png";
    }
?>

<div class="col-md-12 review">
    <div class="row">
        <!-- icone de imagem do user -->
        <div class="col-md-1">
            <div class="profile-image-container review-imagem" style="background-image: url('<?= $BASE_URL ?>image/users/<?=$review->user->image?>');"></div>
            
        </div>

        <div class="col-md-9 author-details-container">
            <h4 class="author-name"><a href="<?=$BASE_URL?>profile.php?id=<?=$review->user->id?>"><?=$fullName?></a></h4>
            <p><i class="fas fa-star"></i> <?=$review->rating?>/10</p>
        </div>

        <div class="col-md-12">
            <p class="comment-title">Comentário:</p>
            <p><?=$review->review?></p>
        </div>
    </div>
</div>