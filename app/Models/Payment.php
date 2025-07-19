<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'amount',
        'location',
        'establishment_id',
        'user_id',
        'payment_mode',
        'type',
        'establishment_shop_id',
        'shop_id',
        'owner_name',
        'phone',
        'email',
        'shop_number',
        'shop_rent',
        'shop_size',
        'tax_amount',
        'shop_type',
        'month',
        'year',
        'is_paid',
        'order_id',
        'transcation_id',
        'interest',
        'payment_method',
        'payment_date',
        'cam_charges',
        'is_arrear',
        'pending_payment_id',
        'is_previous_payment',
    ];
    
    public function establishment()
    {
        return $this->belongsTo(Establishment::class,'establishment_id');
    }
    public function establishment_shop()
    {
        return $this->belongsTo(EstablishmentShop::class,'establishment_shop_id');
    }
    public function shop()
    {
        return $this->belongsTo(Shop::class,'shop_id');
    }
    public function pending_payment()
    {
        return $this->belongsTo(PendingPayment::class,'pending_payment_id');
    }
    public function setAmountAttribute($value){
        $numberWithoutCommas = str_replace(",", "", $value);
        $this->attributes['amount'] = $numberWithoutCommas;
    }
    public function getInterestRate(){
        if($this->month == Carbon::now()->format('F') || $this->shop->is_interest_excluded){
            return 0;
        }
        $currentYear = Carbon::now()->year;
        if (now()->month < 4) {
            $startYear = $currentYear - 1;
            $endYear = $currentYear;
        } else {
            $startYear = $currentYear;
            $endYear = $currentYear + 1;
        }
        return  Payment::where('shop_id',$this->shop_id)
                ->where('month','!=',Carbon::now()->format('F'))
                ->where('type','monthly')
                ->where('is_paid','0')
                ->where(function ($query) use ($startYear,$endYear) {
                    $query->where(function ($query) use ($startYear) {
                        $query->where('year', $startYear)
                            ->whereIn('month', [
                                'April', 'May', 'June', 'July', 'August',
                                'September', 'October', 'November', 'December',
                            ]);
                    });
                    $query->orWhere(function ($query) use ($endYear) {
                        $query->where('year', $endYear)
                            ->whereIn('month', ['January', 'February', 'March']);
                    });
                })
                ->count();
        // if($count > 1){
        //     return $count;
        // }else{
        //     return 0;
        // }
    }
    public function getInterestValue(){
        if($this->shop->is_interest_excluded){
            return 0;
        }
        // $dateString = $this->year . '-' . $this->month . '-01';
        // $paymentDate = Carbon::parse($dateString);
        // $currentDate = Carbon::now();
        // $difference =  $paymentDate->diffInMonths($currentDate);
        $interestAmount = ($this->shop_rent/100) * $this->getInterestRate();
        if($this->interest){
            if($interestAmount > $this->interest){
                return $interestAmount;
            }else{
                return $this->interest;
            }
        }else{
            return $interestAmount;
        }
        // return ($this->shop_rent * ((1 + 0.01) ** $difference)) - $this->shop_rent;
    }
    public function getInterestValueByDate(){
        if($this->shop->is_interest_excluded){
            return 0;
        }
        $currentYear = $this->year;
        $monthNumber = Carbon::parse("1 $this->month")->month; // e.g., 4
        if ($monthNumber < 4) {
            $startYear = $currentYear - 1;
            $endYear = $currentYear;
        } else {
            $startYear = $currentYear;
            $endYear = $currentYear + 1;
        }
        $totalPaymentValue = Payment::where('shop_id',$this->shop_id)
                ->where('type','monthly')
                ->where('is_paid','0')
                ->where(function ($query) use ($startYear,$endYear) {
                    $query->where(function ($query) use ($startYear) {
                        $query->where('year', $startYear)
                            ->whereIn('month', [
                                'April', 'May', 'June', 'July', 'August',
                                'September', 'October', 'November', 'December',
                            ]);
                    });
                    $query->orWhere(function ($query) use ($endYear) {
                        $query->where('year', $endYear)
                            ->whereIn('month', ['January', 'February', 'March']);
                    });
                })
                ->count();
        $interestAmount = ($this->shop_rent/100) * $totalPaymentValue;
        if($this->interest){
            if($interestAmount > $this->interest){
                return $interestAmount;
            }else{
                return $this->interest;
            }
        }else{
            return $interestAmount;
        }
        // return ($this->shop_rent * ((1 + 0.01) ** $difference)) - $this->shop_rent;
    }
    public function getInterestValueForArrear(){
        if($this->shop->is_interest_excluded){
            return 0;
        }
        $currentYear = $this->year;
        $monthNumber = Carbon::parse("1 $this->month")->month; // e.g., 4
        if ($monthNumber < 4) {
            $startYear = $currentYear - 1;
            $endYear = $currentYear;
        } else {
            $startYear = $currentYear;
            $endYear = $currentYear + 1;
        }
        $totalPaymentValue = Payment::where('shop_id',$this->shop_id)
                ->where('type','monthly')
                ->where('is_paid','0')
                ->where(function ($query) use ($startYear,$endYear) {
                    $query->where(function ($query) use ($startYear) {
                        $query->where('year', $startYear)
                            ->whereIn('month', [
                                'April', 'May', 'June', 'July', 'August',
                                'September', 'October', 'November', 'December',
                            ]);
                    });
                    $query->orWhere(function ($query) use ($endYear) {
                        $query->where('year', $endYear)
                            ->whereIn('month', ['January', 'February', 'March']);
                    });
                })
                ->count();
        $interestAmount = ($this->amount/100) * $totalPaymentValue;
        if($this->interest){
            if($interestAmount > $this->interest){
                return $interestAmount;
            }else{
                return $this->interest;
            }
        }else{
            return $interestAmount;
        }
        // return ($this->shop_rent * ((1 + 0.01) ** $difference)) - $this->shop_rent;
    }
    public function getTotalAmount(){
        if($this->is_arrear){
            return @$this->amount + $this->getInterestValueForArrear() + @$this->tax_amount + @$this->cam_charges;
        }else{
            return @$this->shop_rent +@$this->tax_amount +@$this->getInterestValue() + @$this->cam_charges;
        }
    }
    public function getTotalAmountByDate(){
        if($this->is_arrear){
            return @$this->amount + $this->getInterestValueForArrear()+@$this->tax_amount+ @$this->cam_charges;
        }else{
            return @$this->shop_rent +@$this->tax_amount +@$this->getInterestValueByDate() + @$this->cam_charges;
        }
    }
    public function paidAmount(){
        return @$this->collections->whereNotNull('transcation_id')->sum('amount');
    }
    public function dueAmount(){
        if($this->is_previous_payment){
            return $this->getTotalAmountByDate() - @$this->collections->whereNotNull('transcation_id')->sum('amount');
        }else{
            return $this->getTotalAmount() - @$this->collections->whereNotNull('transcation_id')->sum('amount');
        }
    }
    public function collections()
    {
        return $this->hasMany(PaymentCollection::class);
    }
}