<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use FormattedDates;

    const TASQUES_CACHE_KEY = 'tasks.mimoun1997.tasks';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [
        //
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function file()
    {
        return $this->hasOne(File::class);
    }

    public function assignFile(File $file)
    {
        $file->task_id = $this->id;
        $file->save();
    }

    public function complete($completed = true)
    {
        $this->update(compact('completed'));
    }

    public function incomplete()
    {
        $this->complete(false);
    }

    public function map()
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'completed' => (boolean)$this->completed,
            'user_id' => $this->user_id,
            'user_name' => optional($this->user)->name,
            'user_email' => optional($this->user)->email,
            'user_gravatar' => optional($this->user)->gravatar,
            'created_at' => $this->created_at,
            'created_at_formatted' => $this->created_at_formatted,
            'created_at_human' => $this->created_at_human,
            'created_at_timestamp' => $this->created_at_timestamp,
            'updated_at' => $this->updated_at,
            'updated_at_formatted' => $this->updated_at_formatted,
            'updated_at_human' => $this->updated_at_human,
            'updated_at_timestamp' => $this->updated_at_timestamp,
            'user' => $this->user,
            'full_search' => $this->full_search,
            'tags' => $this->tags
        ];
    }

    public function assignUser(User $user)
    {
        $this->user()->associate($user);
        $this->save();
    }

    public function addTag($tag)
    {
        is_int($tag) ? $tag = Tag::find($tag) : $tag;
        //if (is_int($tag)) $tag = Tag::find($tag);
        $this->tags()->save($tag);
        return $this;
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    public function addTags($tags)
    {
        $this->tags()->saveMany($tags);
    }

    public function subject()
    {
        return ellipsis('Tasca pendent (' . $this->id . '): ' . $this->name, 80);
    }
}
