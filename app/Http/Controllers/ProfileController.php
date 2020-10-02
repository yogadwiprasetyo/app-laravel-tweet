<?php

namespace App\Http\Controllers;

use DB;
use App\Profile;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    // TODO: REFACTOR AND DOCUMENTATION
    
    // set random name image
    public function __construct() {
        // $this->image_name = Str::random(10);
        $this->username = "@".Str::random(8);
    }

    /**
     * Joins table to get all information profile
     * 
     * @return Object
     */
    public function profile($id) {
        return DB::table('users')
                  ->join('profile', 'users.id', '=', 'profile.pk_user')
                  ->select('profile.*', 'users.name', 'users.email')
                  ->where('id', $id)
                  ->get();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id) {
        $profile = $this->profile($id);
        $tweet = User::find($profile[0]->pk_user)
                 ->tweet()->orderBy('created_at', 'desc')->get();

        $resource = ['profile' => $profile[0], 'tweet' => $tweet];
        return view('profile.index')->withResource($resource);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        return view('profile.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        // validation
        $request->validate([
            'username' => 'string|required|unique:profile,p_username|alpha_num',
            'status' => 'string|nullable|max:100',
            // 'profile_image' => 'file|nullable|max:2024',
        ]);

        // instance profile model
        $profile = new Profile;

        // set attributes model
        $profile->pk_user = $request->id;
        $profile->p_username = $this->createUsername("@".$request->username, $this->username);
        $profile->p_status = $this->setValue($request->status, "Hello everyone");

        // set image profile by gender
        switch ($request->gender) {
            case 'male': 
                $profile->p_image = "male.svg";
            break;
            case 'female': 
                $profile->p_image = "female.svg";
            break;
            default: $profile->p_image = "others.png";
        }
        
        // !PENDING FEATURES. set user image profile.
        // set attributes image and save to storage
        // $this->setImageProfile($request, $profile);

        // save a new attributes and photo profile
        $profile->save();

        // redirect to edit
        return redirect()->route('home');
        // return redirect('/home');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        $profile = User::find($id)->profile;
        return view('profile.edit')->withProfile($profile);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        // validation
        $request->validate([
            // 'profile_image' => 'file|nullable|max:2024',
            'name' => 'string|required|max:255',
            'username' => 'string|required|max:255',
            'status' => 'string|nullable|max:100',
            'email' => 'email:rfc,dns|required|max:255',
        ]);

        // retrieve specific model
        $profile = User::find($id)->profile;
        $user = User::find($id);

        // updating attributes Users model
        $user->name = $request->name;
        $user->email = $request->email;

        // updating attributes Profile model
        $profile->p_username = $this->createUsername($request->username, $profile->p_username);
        $profile->p_status = $this->setValue($request->status, "Hello everyone");;

        // !PENDING FEATURES. update user image profile.
        // update image profile and delete old image
        // $this->updateImage($request, $profile);

        // save a new attributes
        $user->save();
        $profile->save();

        // redirect to edit
        return redirect()->route('profile.index', ['id' => $id])->with('success', 'Profile update successfully');
    }

    /**
     * Create username startswith @
     * 
     * @param $username
     * @return string
     */
    public function createUsername($username, $defaultUsername) {
        if ($username[0] === "@") {
            return $username;
        }

        return $defaultUsername;
    }

    /**
     * Show form for change password
     * 
     * @return \Illuminate\Http\Response
     */
    public function change() {
        return view('profile.change');
    }

    /**
     * Update password the specified resource in storage.
     * 
     * @param Request $request
     * @param $id
     * 
     * @return \Illuminate\Http\Response
     */
    public function changePassword(Request $request, $id) {
        $request->validate([
            'password1' => 'string|required|min:8',
            'password2' => 'string|required|min:8', 
        ]);

        // Confirm password
        $this->confirmPassword($request->password1, $request->password2);
        
        // change password
        $passwordUpdate = User::find($id);
        $passwordUpdate->password = Hash::make($request->password1);
        $passwordUpdate->save();

        return redirect()
                ->route('profile.index', ['id' => $id])
                ->with('status', 'Change Password Successfully');
    }

    /**
     * Confirm password for updating to storage
     * 
     * @param $password1:string
     * @param $password2:string
     * 
     * @return \Illuminate\Http\Response
     */
    public function confirmPassword($password1, $password2) {
        if ($password1 !== $password2) {
            $error = 'password tidak sama !!!';
            return redirect()->back()->withErrors($error)->withInput();
        } 
    }

        /**
     * Returns default value, if the obtained variable is null or empty
     * 
     * @param $request
     * @param $setvalue
     * 
     * @return string
     */
    public function setValue($request, $defaultValue) {
        if (Str::of($request)->isEmpty()) {
            return $defaultValue;
        }

        return $request;
    }

    /**
     * Create image random name
     * 
     * @param  extension from upload file $extension
     * @return string
     */
    public function imageName($extension_img) {
        return $this->image_name.".$extension_img";
    }

    // ! PENDING FEATURE CHANGE PROFILE IMAGE
    // /**
    //  * Set attribute image profile and saving to storage local
    //  * 
    //  * @param $request
    //  * @return string
    //  */
    // public function setImageProfile($request, $profile) {
    //     // set name image if user don't set p_image
    //     if (!$request->file('profile_image')) {
    //         $profile->p_image = "profile.jpeg";
    //         return;
    //     }
        
    //     // save image file name to model and file to storage
    //     $this->savingUploadFiles($request, $profile);
    // }

    // /**
    //  * Saving image name file to model and file image to storage
    //  * 
    //  * @param Request $request
    //  * @param $profile
    //  */
    // public function savingUploadFiles($request, $profile) {
    //     $extension = $request->file('profile_image')->extension();
    //     $profile->p_image = $this->imageName($extension);
    //     $request->file('profile_image')->storeAs(
    //         'images',
    //         $this->imageName($extension),
    //         'publish'
    //     );
    // }

    // /**
    //  * Update Image on file storage and specific resource.
    //  * 
    //  * @param Request $request
    //  * @param Articles $articles
    //  */
    // public function updateImage($request, $profileUpdate) {
    //     // if image not update
    //     if (!$request->file('profile_image')) {
    //         $profileUpdate->p_image = $profileUpdate->p_image;
    //         return;
    //     }

    //     // if not default image, delete image on storage local
    //     if ($this->isNotDefaultImage($profileUpdate->p_image)) {
    //         // Storage::disk('local')->delete('/images/'.$profileUpdate->p_image);
    //         Storage::disk('publish')->delete('/images/'.$profileUpdate->p_image);
    //     }
        
    //     // save image file name to model and file to storage
    //     $this->savingUploadFiles($request, $profileUpdate);
    // }

    // /**
    //  * Check image default name, if default return true
    //  * 
    //  * @param $name
    //  * @return bool
    //  */
    // public function isNotDefaultImage($imagename) {
    //     return $imagename !== 'profile.jpeg';
    // }
}