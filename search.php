<?php

include 'components/connect.php';

if(isset($_POST['search'])) {
    $search_query = $_POST['search'];

    // Fetch posts based on the search query
    $select_posts = $conn->prepare("SELECT * FROM `posts` WHERE `title` LIKE ?");
    $select_posts->execute(['%' . $search_query . '%']);

    if($select_posts->rowCount() > 0){
       while($fetch_post = $select_posts->fetch(PDO::FETCH_ASSOC)){
          $post_id = $fetch_post['id'];

          // Count reviews for each post
          $count_reviews = $conn->prepare("SELECT * FROM `reviews` WHERE post_id = ?");
          $count_reviews->execute([$post_id]);
          $total_reviews = $count_reviews->rowCount();
       ?>
          <div class="box">
             <img src="uploaded_files/<?= $fetch_post['image']; ?>" alt="" class="image">
             <h3 class="title"><?= $fetch_post['title']; ?></h3>
             <p class="total-reviews"><i class="fas fa-star"></i> <span><?= $total_reviews; ?></span></p>
             <a href="view_post.php?get_id=<?= $post_id; ?>" class="inline-btn">view post</a>
          </div>
       <?php
       }
    }else{
       echo '<p class="empty">No posts found!</p>';
    }
} else {
    echo '<p class="empty">No search query provided!</p>';
}
?>
