package com.moro274.mongo_commentaries_recipes.repository;


import com.moro274.mongo_commentaries_recipes.entity.Comment;
import org.springframework.data.mongodb.repository.MongoRepository;

import java.util.List;

public interface CommentRepository extends MongoRepository<Comment, String> {
    List<Comment> findByRecipeIdOrderByDateDesc(String recipeId);

    List<Comment> findByRecipeId(String s);
}
