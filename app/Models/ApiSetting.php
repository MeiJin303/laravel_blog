<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Http;
use App\Models\User;
use Symfony\Component\HttpKernel\Exception\HttpException;

class ApiSetting extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'api_url',
        'active',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'active' => 'boolean',
    ];

    // setup  one to one relationship with User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // static method to return a human readable string for durations
    static public function executeDurationForHuman($minutes)
    {
        return number_format($minutes/60, 2);
    }

    public function durationForHuman()
    {
        return self::executeDurationForHuman($this->execute_duration_min);
    }

    /**
     * Fetch feed from defined API URL
     *
     * @return JSON
     */
    public function fetch()
    {
        try{
            $response = Http::get($this->api_url);
        } catch(HttpException $e) {
            $this->error_message = $e->getMessage();
            return false;
        }
        $this->next_executed_at = now()->addMinutes($this->execute_duration_min);

        $data = json_decode($response);
        if (isset($data->data))
        {
            $data = $data->data;
        }
        else
        {
            $this->error_message = "Invalid JSON Format";
        }

        $this->save();

        foreach($data as $d)
        {
            $post = new Post;
            $post->user_id = $this->user_id;
            $post->title = $d->title;
            $post->description = $d->description;
            $post->created_at = $d->publication_date;
            $post->save();
        }

        return true;
    }
}

