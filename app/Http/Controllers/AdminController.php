<?php

namespace App\Http\Controllers;

use App\Models\Video;
use App\Models\Statement;
use App\Models\Comment;
use App\Models\User;
use App\Models\Complaint;
use App\Models\Category;
use App\Models\Reason;
use App\Models\Message;
use App\Models\Ban;

use PDF;
use Laracasts\Flash\Flash;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class AdminController extends Controller
{

    public function index(Request $request)
    {
        $status = $request->input('status');
        $role = $request->input('role');


        $usersQuery = User::query();
        $videosQuery = Video::query();
        $statementsQuery = Statement::query();
    
        if ($status) {
            $usersQuery->whereHas('complaints', function ($query) use ($status) {
                $query->where('role', $status);
            });
            $videosQuery->whereHas('complaints', function ($query) use ($status) {
                $query->where('status', $status);
            });
            $statementsQuery->whereHas('complaints', function ($query) use ($status) {
                $query->where('status', $status);
            });
        }

        if ($role) {
            $usersQuery->where('role', $role);
        }
    
        $users = $usersQuery->get();
        $videos = $videosQuery->get();
        $statements = $statementsQuery->get();

    
        return view('admin.adminnavigation', compact('users', 'videos', 'statements'));
    }


    //BLOCKED



    public function blockedUsers(Request $request)
    {
        $role = $request->input('role');
    
        $usersQuery = User::query();
    
        if ($role) {
            $usersQuery->where('role', $role);
        }
    
        // Получаем только заблокированных пользователей
        $users = $usersQuery->whereHas('bans')->get();
    
        return view('admin.adminnavigation', compact('users'));
    }

    public function blockedStatements(Request $request)
    {

    
        $statementsQuery = Statement::query();
    

    
        // Получаем только заблокированных пользователей
        $statements = $statementsQuery->whereHas('bans')->get();
    
        return view('admin.adminnavigation', compact('statements'));
    }

    public function blockedVideos(Request $request)
    {

    
        $videosQuery = Video::query();
    

    
        // Получаем только заблокированных пользователей
        $videos = $videosQuery->whereHas('bans')->get();
    
        return view('admin.adminnavigation', compact('videos'));
    }

    //UNBLOCKED
    
    public function unblockedUsers(Request $request)
    {
        $role = $request->input('role');
    
        $usersQuery = User::query();
    
        if ($role) {
            $usersQuery->where('role', $role);
        }
    
        // Получаем пользователей, у которых нет записей в таблице блокировок
        $users = $usersQuery->whereDoesntHave('bans')->get();
    
        return view('admin.adminnavigation', compact('users'));
    }

    public function unblockedStatements(Request $request)
    {


        $statementsQuery = Statement::query();

    
        // Получаем пользователей, у которых нет записей в таблице блокировок
        $statements = $statementsQuery->whereDoesntHave('bans')->get();
    
        return view('admin.adminnavigation', compact('statements'));
    }

    public function unblockedVideos(Request $request)
    {


        $videosQuery = Video::query();

    
        // Получаем пользователей, у которых нет записей в таблице блокировок
        $videos = $videosQuery->whereDoesntHave('bans')->get();
    
        return view('admin.adminnavigation', compact('videos'));
    }


    //SEND COMPLAINT

    public function blockvideo(Request $request, $id)
    {
        $user = auth()->user();

        $complaint = new Complaint([
            'reason' => $request->reason,
            'status' => 'new',
            'video_id' => $id,
            'statement_id' => null,
            'user_id' => null,
        ]);

        $complaint->sender_id = $user->id;

        $complaint->save();

        return redirect()->back();
    }

    public function blockuser(Request $request, $id)
    {
        $user = auth()->user();

        $complaint = new Complaint([
            'reason' => $request->reason,
            'status' => 'new',
            'video_id' => null,
            'statement_id' => null,
            'user_id' => $id,
        ]);

        $complaint->sender_id = $user->id;

        $complaint->save();

        return redirect()->back();
    }

    public function blockstatement(Request $request, $id)
    {
        $user = auth()->user();

        $complaint = new Complaint([
            'reason' => $request->reason,
            'status' => 'new',
            'video_id' => null,
            'statement_id' => $id,
            'user_id' => null,
        ]);

        $complaint->sender_id = $user->id;

        $complaint->save();

        return redirect()->back();
    }

    





// ADMIN BAN


    public function post_statement_complaint(Request $request, Statement $statement){



        $ban = new Ban([
            'sender_id' => auth()->user()->id,
            'reason_id' => 1,
            'video_id' => null,
            'statement_id' => $statement->id,
            'user_id' => null,
        ]);

        $statement->complaints()->update(['status' => $request->edit_status]);


        $ban -> save();

        return redirect()->back();
    }


    public function post_video_complaint(Request $request, Video $video){

        $ban = new Ban([
            'sender_id' => auth()->user()->id,
            'reason_id' => 1,
            'video_id' => $video->id,
            'statement_id' => null,
            'user_id' => null,
        ]);


        $video->complaints()->update(['status' => $request->edit_status]);

        $ban -> save();

        return redirect()->back();
    }

public function post_user_complaint(Request $request, User $user){
    $ban = new Ban([
        'sender_id' => auth()->user()->id,
        'reason_id' => 1,
        'video_id' => null,
        'statement_id' => null,
        'user_id' => $user->id,
    ]);

    $user->complaints()->update(['status' => $request->edit_status]);

    $ban->save();

    return redirect()->back();
}



// ADMIN DELETE BAN
public function delete_ban_user(Request $request, User $user){

    $ban = Ban::where('user_id', $user->id)->firstOrFail();


    $user->complaints()->update(['status' => $request->edit_status]);


    $ban->delete();


    return redirect()->back();
}

public function delete_ban_video(Request $request, Video $video){

    $ban = Ban::where('video_id', $video->id)->firstOrFail();


    $video->complaints()->update(['status' => $request->edit_status]);


    $ban->delete();


    return redirect()->back();
}

public function delete_ban_statement(Request $request, Statement $statement){

    $ban = Ban::where('statement_id', $statement->id)->firstOrFail();


    $statement->complaints()->update(['status' => $request->edit_status]);


    $ban->delete();


    return redirect()->back();
}





    //DELETE BLOCK

    public function deleteStatement(Request $request, Statement $statement)
    {
        if (auth()->user()->role !== 'Admin') {
            abort(403, 'У вас нет прав на удаление этого фотоматериала');
        }

        $statement->delete();

        return back();
    }

    public function deleteVideo(Request $request, Video $video)
    {
        if (auth()->user()->role !== 'Admin') {
            abort(403, 'У вас нет прав на удаление этого видеоматериала');
        }

        $video->delete();

        return back();
    }

    public function deleteUser(Request $request, User $user)
    {

        if (auth()->user()->role !== 'Admin') {
            abort(403, 'У вас нет прав на удаление этого пользователя');
        }


        $user->delete();

        return back();
    }



    //Create NEW
    public function ViewCreateCategoey(){

        $categories = Category::all();
        $reasons = Reason::all();

        return view('admin.adminadd', compact('categories', 'reasons'));

    }

    public function ViewCreateReason(){

        $categories = Category::all();
        $reasons = Reason::all();

        return view('admin.adminadd', compact('categories', 'reasons'));

    }


    public function createCategory(Request $request){

        Category::create($request->all());


        Flash::success('
            
        <div class="flash-success">
        <div class="flsh-title">
            K-PAC
        </div>
        <div class="flash-message">
        Категория успешно создана!
        </div>
        </div>');

        return back();
    }

    
    public function createReason(Request $request){

        Reason::create($request->all());


        Flash::success('
            
        <div class="flash-success">
        <div class="flsh-title">
            K-PAC
        </div>
        <div class="flash-message">
        Причина успешно создана!
        </div>
        </div>');

        return back();
    }

//DeleteAdmin

public function deleteCategory(Category $category)
{
    $category->delete();

    return response()->json(['success' => true]);
}

public function deleteReason(Reason $reason)
{
    $reason->delete();

    return response()->json(['success' => true]);
}



//UpdateAdmin

public function updateCategory(Request $request, Category $category)
{
    $category->name = $request->input('name');
    $category->save();

    return response()->json(['success' => true]);
}

public function updateReason(Request $request, Reason $reason)
{
    $reason->name = $request->input('name');
    $reason->save();

    return response()->json(['success' => true]);
}


//SearchAdminInput
public function autocomplete_admin_users(Request $request)
{
    $searchTerm = $request->input('search');

    $users = User::query()
        ->where('name', 'LIKE', '%' . $searchTerm . '%')
        ->get();

    $usersWithBlockStatus = [];

    foreach ($users as $user) {
        $isBlocked = $user->isBlocked(); 
        $userWithBlockStatus = $user->toArray(); //объект в массив
        $userWithBlockStatus['is_blocked'] = $isBlocked;

        if ($user->bans) {
            //элементы bans
            if ($user->bans->isNotEmpty()) {

                $userWithBlockStatus['first_ban'] = [
                    'created_at' => $user->bans->first()->created_at,
                    'sender_name' => $user->bans->first()->sender ? $user->bans->first()->sender->name : null,
                    'reason_name' => $user->bans->first()->reason ? $user->bans->first()->reason->name : null
                ];
            }
        }
    
        $usersWithBlockStatus[] = $userWithBlockStatus;
    }

    $base_url = url('/storage/');

    return response()->json(['users' => $usersWithBlockStatus, 'base_url' => $base_url]);
}


    public function autocomplete_admin_videos(Request $request)
    {
        $searchTerm = $request->input('search');

        $videos = Video::query()
            ->where('title', 'LIKE', '%' . $searchTerm . '%')
            ->with('user')
            ->get();

            $videosWithBlockStatus = [];

            foreach ($videos as $video) {
                $isBlocked = $video->isBlocked(); 
                $videoWithBlockStatus = $video->toArray(); //объект в массив
                $videoWithBlockStatus['is_blocked'] = $isBlocked;
        
                if ($video->bans) {
                    //элементы bans
                    if ($video->bans->isNotEmpty()) {
        
                        $videoWithBlockStatus['first_ban'] = [
                            'created_at' => $video->bans->first()->created_at,
                            'sender_name' => $video->bans->first()->sender ? $video->bans->first()->sender->name : null,
                            'reason_name' => $video->bans->first()->reason ? $video->bans->first()->reason->name : null
                        ];
                    }
                }
            
                $videosWithBlockStatus[] = $videoWithBlockStatus;
            }


        $base_url = url('/storage/');

        return response()->json(['videos' => $videosWithBlockStatus, 'base_url' => $base_url]);
    }

    public function autocomplete_admin_statements(Request $request)
    {
        $searchTerm = $request->input('search');

        $statements = Statement::query()
        ->where('title', 'LIKE', '%' . $searchTerm . '%')
        ->with('user')
        ->get();

        $statementsWithBlockStatus = [];

        foreach ($statements as $statement) {
            $isBlocked = $statement->isBlocked(); 
            $statementWithBlockStatus = $statement->toArray(); //объект в массив
            $statementWithBlockStatus['is_blocked'] = $isBlocked;
    
            if ($statement->bans) {
                //элементы bans
                if ($statement->bans->isNotEmpty()) {
    
                    $statementWithBlockStatus['first_ban'] = [
                        'created_at' => $statement->bans->first()->created_at,
                        'sender_name' => $statement->bans->first()->sender ? $statement->bans->first()->sender->name : null,
                        'reason_name' => $statement->bans->first()->reason ? $statement->bans->first()->reason->name : null
                    ];
                }
            }
        
            $statementsWithBlockStatus[] = $statementWithBlockStatus;
        }
    
        $base_url = url('/storage/');

        return response()->json(['statements' => $statementsWithBlockStatus, 'base_url' => $base_url]);
    }


//UpdateRoleUsers

public function update_user_role(Request $request, User $user){


    $user->update(['role' => $request->role]);

    $user->save();

    return redirect()->back();
}


// AdminCheckDialogs
public function showMessengerAdmin(User $user)
{

    $dialogs = Message::select('sender_id', 'recipient_id')
        ->where('sender_id', $user->id)
        ->orWhere('recipient_id', $user->id)
        ->groupBy('sender_id', 'recipient_id')
        ->get();


    $dialogs = $dialogs->filter(function ($dialog) {
        return $dialog->sender_id != $dialog->recipient_id;
    });


    foreach ($dialogs as $dialog) {
        $lastMessage = Message::where(function ($query) use ($dialog) {
            $query->where('sender_id', $dialog->sender_id)
                ->where('recipient_id', $dialog->recipient_id);
        })->orWhere(function ($query) use ($dialog) {
            $query->where('sender_id', $dialog->recipient_id)
                ->where('recipient_id', $dialog->sender_id);
        })->orderByDesc('created_at')->first();


        $dialog->lastMessage = $lastMessage;
        $dialog->user = User::find($dialog->sender_id);
    }

    return view('messenger.messenger', compact('dialogs', 'user'));
}

//AdminCheckDialog
public function showChatAdmin($userId, $dialogId)
    {

        $user = User::findOrFail($userId);
        $recipient = User::findOrFail($dialogId);


        if (auth()->user()->role !== 'Admin') {
                abort(403, 'У вас нет прав администратора.');
        }


        $dialogs = Message::select('sender_id', 'recipient_id')
            ->where('sender_id', $userId)
            ->orWhere('recipient_id', $userId)
            ->groupBy('sender_id', 'recipient_id')
            ->get();


        $dialogs = $dialogs->filter(function ($dialog) {
            return $dialog->sender_id != $dialog->recipient_id;
        });

// Получаем список сообщений для указанного диалога
$messages = Message::where(function ($query) use ($userId, $dialogId) {
    $query->where('sender_id', $userId)
          ->where('recipient_id', $dialogId);
})
->orWhere(function ($query) use ($userId, $dialogId) {
    $query->where('sender_id', $dialogId)
          ->where('recipient_id', $userId);
})
->orderBy('created_at')
->get();

// dd($messages);

        foreach ($dialogs as $dialog) {
            $lastMessage = Message::where(function ($query) use ($dialog) {
                $query->where('sender_id', $dialog->sender_id)
                    ->where('recipient_id', $dialog->recipient_id);
            })->orWhere(function ($query) use ($dialog) {
                $query->where('sender_id', $dialog->recipient_id)
                    ->where('recipient_id', $dialog->sender_id);
            })->orderByDesc('created_at')->first();

            $dialog->lastMessage = $lastMessage;
            $dialog->user = User::find($dialog->sender_id);
        }

        return view('messenger.messenger', compact('dialogs', 'user', 'messages', 'recipient'));
    }



    //AdminDownloadDialog
    public function downloadChatPdf($userId, $dialogId)
    {
        $user = User::findOrFail($userId);
    
        if (auth()->user()->role !== 'Admin') {
            abort(403, 'У вас нет прав администратора.');
        }
    
        $messages = Message::where(function ($query) use ($userId, $dialogId) {
                $query->where('sender_id', $userId)
                      ->where('recipient_id', $dialogId);
            })
            ->orWhere(function ($query) use ($userId, $dialogId) {
                $query->where('sender_id', $dialogId)
                      ->where('recipient_id', $userId);
            })
            ->orderBy('created_at')
            ->get();
    
        $recipient = User::find($dialogId);
    
        $pdf = PDF::loadView('pdf.chat', compact('user', 'messages', 'recipient'));
    
        return $pdf->download('Чат_пользователя' . $user->id . '_с_пользователем_' . $dialogId . '.pdf');
    }


}
