package com.moro274.mongo_commentaries_recipes.controller;

import com.fasterxml.jackson.databind.ObjectMapper;
import com.moro274.mongo_commentaries_recipes.entity.Comment;
import com.moro274.mongo_commentaries_recipes.repository.CommentRepository;
import org.springframework.http.ResponseEntity;
import org.springframework.web.bind.annotation.*;

import java.util.Date;
import java.util.List;
import java.util.Map;

@RestController
@RequestMapping("/api/comments")
@CrossOrigin
public class CommentController {

    private final CommentRepository repository;

    public CommentController(CommentRepository repository) {
        this.repository = repository;
    }

    @GetMapping("/{recipeId}")
    public List<Comment> getCommentsByRecipe(@PathVariable String recipeId) {
        return repository.findByRecipeId(
                recipeId);
    }

    @PostMapping("/{recipeId}")
    public ResponseEntity<?> addComment(@PathVariable String recipeId, @RequestBody Comment comment) {
        comment.setDate(new Date());
        comment.setRecipeId(recipeId);
        repository.save(comment);
        return ResponseEntity.ok(Map.of("success", true));
    }

    @PutMapping("/{id}")
    public ResponseEntity<?> updateComment(@PathVariable String id, @RequestBody Comment newData) {
        return repository.findById(id)
                .map(existing -> {
                    existing.setName(newData.getName());
                    existing.setEmail(newData.getEmail());
                    existing.setContent(newData.getContent());
                    existing.setScore(newData.getScore());
                    existing.setAttachments(newData.getAttachments());
                    repository.save(existing);
                    return ResponseEntity.ok(Map.of("success", true));
                })
                .orElse(ResponseEntity.notFound().build());
    }

    @DeleteMapping("/{id}")
    public ResponseEntity<?> deleteComment(@PathVariable String id) {
        if (repository.existsById(id)) {
            repository.deleteById(id);
            return ResponseEntity.ok(Map.of("success", true));
        }
        return ResponseEntity.notFound().build();
    }

    @GetMapping("/{recipeId}/score")
    public ResponseEntity<?> getAverageScore(@PathVariable String recipeId) {
        List<Comment> comments = repository.findByRecipeIdOrderByDateDesc(recipeId);
        double average = comments.stream()
                .filter(c -> c.getScore() != null)
                .mapToInt(Comment::getScore)
                .average()
                .orElse(0.0);
        return ResponseEntity.ok(Map.of(
                "recipeId", recipeId,
                "averageScore", average
        ));
    }
}
