<?php

namespace Tests;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication, RefreshDatabase;
}


/** @test */

    //   /** @test  */
    //   public function a_user_belongs_to_many_roles()
    //   {
    //       $user = factory(User::class)->create();
    //       $role = factory(Role::class)->create();

    //       $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $user->roles);
    //   }

    // morphTo
    // ...
    // /** @test */
    // public function a_comment_can_be_morphed_to_a_video_model()
    // {
    //     $comment = factory(Comment::class)->create([
    //       "commentable_id" => $this->video->id,
    //       "commentable_type" => "App\Video",
    //     ]);

    //     $this->assertInstanceOf(Video::class, $comment->commentable);
    // }

    // /** @test */
    // public function a_comment_can_be_morphed_to_a_post_model()
    // {
    //     $comment = factory(Comment::class)->create([
    //       "commentable_id" => $this->post->id,
    //       "commentable_type" => "App\Post",
    //     ]);

    //     $this->assertInstanceOf(Post::class, $comment->commentable);
    // }

    //MorphOne::class
    // /** @test  */
    // public function a_user_morphs_one_image()
    // {
    //     $this->assertInstanceOf(Image::class, $this->user->image);
    // }

    //MorphTo
    //    /** @test */
    //    public function a_comment_can_be_morphed_to_a_video_model()
    //    {
    //        $comment = factory(Comment::class)->create([
    //          "commentable_id" => $this->video->id,
    //          "commentable_type" => "App\Video",
    //        ]);

    //        $this->assertInstanceOf(Video::class, $comment->commentable);
    //    }

    //    /** @test */
    //    public function a_comment_can_be_morphed_to_a_post_model()
    //    {
    //        $comment = factory(Comment::class)->create([
    //          "commentable_id" => $this->post->id,
    //          "commentable_type" => "App\Post",
    //        ]);

    //        $this->assertInstanceOf(Post::class, $comment->commentable);
    //    }

    //MorphMany
    // /** @test  */
    // public function videos_database_has_expected_columns()
    // {
    //     $this->assertTrue(
    //       Schema::hasColumns('videos', [
    //         'id','user_id', 'title', 'description', 'size', 'length'
    //     ]), 1);
    // }

    // /** @test  */
    // public function a_video_morphs_many_comments()
    // {
    //     $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $this->video->comments);
    // }
