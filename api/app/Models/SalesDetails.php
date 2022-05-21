<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SalesDetails extends Model
{
    use HasFactory, SoftDeletes, Notifiable;

     /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'customer_name',
        'customer_email',
        'customer_phone',
        'sale_date',
        'car'
    ];

     /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'sale_date' => 'date',
    ];

    /**
     *  Many To One -> Car
     * 
     *  @return Illuminate\Database\Eloquent\Relations\BelongsTo;
     * 
     */
    public function car():BelongsTo {
        return $this->belongsTo(Car::class);
    }

    /**
     * Route notifications for the mail channel.
     *
     * @param  \Illuminate\Notifications\Notification  $notification
     * @return array|string
     */
    public function routeNotificationForMail($notification)
    {
        // Return email address only...
        return $this->customer_email;
 
        // Return email address and name...
        return [$this->customer_email => $this->customer_name];
    }


    public static function getSumm() {
        $raw = DB::table('sales_details')
                        ->selectRaw('CAST(sale_date as DATE) as sale_date, car_name, 
                                     COUNT(*) as total_sold, SUM(car_price) as total_sum')
                        ->leftJoin('cars', 'cars.id', '=', 'sales_details.car')
                        ->groupByRaw('CAST(sale_date as DATE), car_name')
                        ->orderByRaw('sale_date, car_name')
                        ->havingRaw('COUNT(*) > 0')
                        ->get()->toArray();
        // conver to array php way
        return json_decode(json_encode($raw), TRUE);
    }
    
}
