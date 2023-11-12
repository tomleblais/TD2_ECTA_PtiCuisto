<?php $title = "Petit Cuisto"; ?>

<?php ob_start(); ?>
<h1>Petit cuisto</h1>

<div class="banner-container">
    <img src="https://assets.afcdn.com/story/20220126/2157919_w472h265c1cx1063cy706cxt0cyt0cxb2125cyb1411.webp" alt="" class="banner-image" width="100%">
</div>

<div class="main-container">
    <div class="main-container-left container">
        <h1>Les dernières recettes</h1>
        <div class="recipe-container">
            <div class="recipe">
                <div class="recipe-left">
                    <img src="https://assets.afcdn.com/story/20220126/2157919_w472h265c1cx1063cy706cxt0cyt0cxb2125cyb1411.webp" alt="" class="recipe-image">
                </div>
                <div class="recipe-right">
                    <h3>Recette</h3>
                    <p class="recipe-content">
                        Lorem ipsum dolor sit amet consectetur adipisicing elit. Recusandae, reiciendis? Reprehenderit id nam porro totam similique officia, laboriosam aliquam voluptatum repellendus, odit consequuntur iste ducimus. Molestiae repellendus odit quia vero!
                    </p>
                </div>
            </div>
            <div class="recipe">
                <div class="recipe-left">
                    <img src="https://assets.afcdn.com/story/20220126/2157919_w472h265c1cx1063cy706cxt0cyt0cxb2125cyb1411.webp" alt="" class="recipe-image">
                </div>
                <div class="recipe-right">
                    <h3>Recette</h3>
                    <p class="recipe-content">
                        Lorem ipsum dolor sit amet consectetur adipisicing elit. Recusandae, reiciendis? Reprehenderit id nam porro totam similique officia, laboriosam aliquam voluptatum repellendus, odit consequuntur iste ducimus. Molestiae repellendus odit quia vero!
                    </p>
                </div>
            </div>
            <div class="recipe">
                <div class="recipe-left">
                    <img src="https://assets.afcdn.com/story/20220126/2157919_w472h265c1cx1063cy706cxt0cyt0cxb2125cyb1411.webp" alt="" class="recipe-image">
                </div>
                <div class="recipe-right">
                    <h3>Recette</h3>
                    <p class="recipe-content">
                        Lorem ipsum dolor sit amet consectetur adipisicing elit. Recusandae, reiciendis? Reprehenderit id nam porro totam similique officia, laboriosam aliquam voluptatum repellendus, odit consequuntur iste ducimus. Molestiae repellendus odit quia vero!
                    </p>
                </div>
            </div>
        </div>
    </div>
    <div class="main-container-right secondary container">
        <img src="https://assets.afcdn.com/story/20220126/2157919_w472h265c1cx1063cy706cxt0cyt0cxb2125cyb1411.webp" alt="" width="100" height="100" class="edito-image">
        <h1 class="edito-title">Edito</h1>
        <div class="edito-content">
            <p class="edito-paragraph">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Voluptates deserunt natus tempora nesciunt id numquam laboriosam a harum quos dolorum iusto modi ullam cupiditate ea magnam consequuntur quod, provident voluptatem.</p>
            <p class="edito-paragraph">Eaque dolor enim facilis, veritatis temporibus numquam labore impedit eveniet libero harum error soluta maiores neque alias omnis quas eum nobis excepturi voluptatum eligendi. Expedita repellat ut fuga autem aperiam?</p>
            <p class="edito-paragraph">Voluptate sed libero laboriosam quia corporis! Laboriosam, officia aliquam delectus, dolores possimus odio accusantium veritatis id dolorem modi totam ea consequatur dolore aspernatur rem sapiente, repudiandae culpa illo esse doloribus!</p>
        </div>
    </div>
</div>

<?php $content = ob_get_clean(); ?>

<?php require('./templates/layout.php') ?>