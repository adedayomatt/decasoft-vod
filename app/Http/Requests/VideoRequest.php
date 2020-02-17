<?php

namespace App\Http\Requests;

use App\Http\Traits\FileUpload;
use Illuminate\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

@ini_set( 'upload_max_filesize' , '512M' );
@ini_set( 'post_max_size', '512M');
@ini_set( 'memory_limit', '512M' );
@ini_set( 'max_execution_time', '300' );
@ini_set( 'max_input_time', '300' );

class VideoRequest extends FormRequest
{
    use FileUpload;
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        switch($this->method()){
            case 'POST':
                return [
                    'title' => ['required', 'string', 'max:255'],
                    'cover_image' => ['required', 'mimes:'.implode(',', $this->acceptedCoverFormats())],
                    'video_file' => ['required', 'mimes:'.implode(',', $this->acceptedVideoFormats())],
                    'price' => ['required', 'numeric']
                ];
            break;

            case 'PUT':
                return [
                    'title' => ['required', 'string', 'max:255'],
                    'price' => ['required', 'numeric']
                ];
            break;
        }
    }

    /**
     * After the validations are passed, let't proceed to try uploading the video
     */
    public function withValidator(Validator $validator)
    {
        $this->validator = $validator;

        $validator->after(function ($validator){
            if($this->method() == "POST") {
                // video upload
                $this->uploadVideo();
                // cover upload
                $this->uploadCover();
            }
            elseif($this->method() == "PUT"){
                if($this->has('cover_image')){
                    $this->uploadCover();
                }
            }
        });
    }

    /**
     * video format that are accepted
     */
    private function acceptedVideoFormats(){
        return ['mp4', 'avi', 'mkv'];
    }

    /**
     * cover image format that are accepted
     */
    private function acceptedCoverFormats(){
        return ['jpg', 'jpeg', 'png', 'gif'];
    }

    /**
     * upload the cover
     */
    private function uploadCover(){
        $cover_upload = $this->upload(
            $name = 'cover_image',
            $save_as = str_slug($this->title).time(),
            $to = 'videos',
            $accept = $this->acceptedCoverFormats()
        );

        if($cover_upload['error'] == null && $cover_upload['filename'] != null){
            $this->uploaded_cover = $cover_upload['filename'];
            return true;
        }else{
            $this->validator->errors()->add('cover_image', $cover_upload['error']);
            return false;
        }
    }

    /**
     * upload the video
     */
    public function uploadVideo(){
        $video_upload = $this->upload(
            $name = 'video_file',
            $save_as = str_slug($this->title).time(),
            $to = 'videos',
            $accept = $this->acceptedVideoFormats()
        );

       if($video_upload['error'] == null && $video_upload['filename'] != null){
            $this->uploaded_video = $video_upload['filename'];
            return true;
        }else{
            $this->validator->errors()->add('video_file', $video_upload['error']);
            return false;
        }
    }

}
