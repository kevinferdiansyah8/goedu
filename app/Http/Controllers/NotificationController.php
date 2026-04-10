namespace App\Http\Controllers;

use Illuminate\Http\Request;


class NotificationController extends Controller
{
    /**
     * Mark all notifications as read for the authenticated user.
     */
    public function markAllAsRead()
    {
        if (auth()->check()) {
            auth()->user()->unreadNotifications->markAsRead();
            return response()->json(['success' => true]);
        }
        return response()->json(['success' => false], 401);
    }

    /**
     * Mark a single notification as read.
     */
    public function markAsRead($id)
    {
        if (auth()->check()) {
            $notification = auth()->user()->unreadNotifications()->where('id', $id)->first();
            if ($notification) {
                $notification->markAsRead();
                return response()->json(['success' => true]);
            }
        }
        return response()->json(['success' => false], 401);
    }
}
