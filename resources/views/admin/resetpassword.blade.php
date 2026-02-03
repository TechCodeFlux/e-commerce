use App\Models\Club;
use Illuminate\Support\Facades\Hash;

$club = Club::where('email', 'ap@123')->first();
$club->password = Hash::make('1234');
$club->save();
{{-- to change password in terminal using
  php artisan tinker --command on terminal 1st --}}