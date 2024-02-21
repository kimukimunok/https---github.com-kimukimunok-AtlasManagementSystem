<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\Users\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Http\Requests\RegisterRequest;
use DB;

use App\Models\Users\Subjects;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    public function registerView()
    {
        $subjects = Subjects::all();
        return view('auth.register.register', compact('subjects'));
    }

    public function registerPost(Request $request)
    {
        DB::beginTransaction();
        // データベース更新処理
        try {
            // 生年月日
            $old_year = $request->old_year;
            $old_month = $request->old_month;
            $old_day = $request->old_day;
            $data = $old_year . '-' . $old_month . '-' . $old_day;
            $birth_day = date('Y-m-d', strtotime($data));
            // 役職が生徒を選んだ時、選択科目を選ばせる。→subjectsテーブルに保存する。
            // →違う、科目そのものは選んでない。subjects_usersに保存する。
            $subjects = $request->input('subject');

            $user_get = User::create([
                'over_name' => $request->over_name,
                'under_name' => $request->under_name,
                'over_name_kana' => $request->over_name_kana,
                'under_name_kana' => $request->under_name_kana,
                'mail_address' => $request->mail_address,
                'sex' => $request->sex,
                'birth_day' => $birth_day,
                'role' => $request->role,
                'password' => bcrypt($request->password)
            ]);
            // dd($user_get);送れている確認

            // findOrFailメソッド=値がな時はエラーを返す
            // ※findメソッド=値が無ければnullと返す。エラーの原因が突き止めやすくなるため、findOrFailメソッドの方が良い。
            $user = User::findOrFail($user_get->id);
            // attachメソッド=中間テーブルにデータを挿入
            // ユーザーも科目も両方複数ある為多対多の処理の為複数形にする。
            $user->subjects()->attach($subjects);

            //気が付いた。そもそも科目を選択していない(現状選択肢にないから出来てない。)から、NULLが返ってくる。上の処理を一度消したら登録とログインできてしまった。
            // 科目の選択肢を作る所から次は行おうか！！

            // データベースに変更を保存
            DB::commit();
            return view('auth.login.login');
        }
        catch (\Exception $e) {
            // データベースの保存に失敗した時、処理を破棄する(更新前に戻す)
            DB::rollback();
            return redirect()->route('loginView');
        }
    }
}
