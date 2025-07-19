<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shop extends Model
{
    use HasFactory;

    protected $fillable = [
        'shop_name',
        'owner_name',
        'phone',
        'email',
        'shop_number',
        'shop_rent',
        'lat_long',
        'rent_frequency',
        'zone_id',
        'establishment_id',
        'location_id',
        'structure_id',
        'establishment_category_id',
        'ward_id',
        'shop_size',
        'shop_type',
        'id_proof',
        'id_proof_number',
        'customer_id',
        'location',
        'establishment_shop_id',
        'allotment_date',
        'number_of_years',
        'valid_upto',
        'allotment_number',
        'trade_license_number',
        'user_id',
        'owner_type',
        'tenant_name',
        'tenant_phone',
        'tenant_email',
        'is_interest_excluded',
    ];
    public function qrCodes()
    {
        return $this->hasMany(QrCode::class, 'shop_id');
    }
    public function arrears()
    {
        return $this->hasMany(PendingPayment::class, 'shop_id');
    }
    public function establishment_shop()
    {
        return $this->belongsTo(EstablishmentShop::class, 'establishment_shop_id');
    }
    public function establishment_category()
    {
        return $this->belongsTo(EstablishmentCategory::class, 'establishment_category_id');
    }
    public function establishment()
    {
        return $this->belongsTo(Establishment::class, 'establishment_id');
    }
    public function zone()
    {
        return $this->belongsTo(Zone::class, 'zone_id');
    }
    public function ward()
    {
        return $this->belongsTo(Ward::class, 'ward_id');
    }
    public function structure()
    {
        return $this->belongsTo(Structure::class, 'structure_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function allowPayment()
    {
        $count  = Payment::whereMonth('payment_date', Carbon::now()->month)
            ->where('shop_id', operator: $this->id)
            ->where('is_paid', 1)
            ->count();
        if ($count > 0) {
            return false;
        }
        return true;
    }
    // public function getQRCode($height,$width)
    // {
    //     return "https://quickchart.io/qr?size=200x200&text={'establishment_id':'"
    //     .$this->establishment_id."','establishment_name':'".@$this->establishment->name."','shop_id':'".@$this->id."','address':'".@$this->location.
    //     "','establishment_shop_id':'".@$this->establishment_shop_id."','shop_number':'".$this->shop_number."','shop_name':'".@$this->shop_name.
    //     "','owner_name':'".@$this->owner_name."','phone':'".$this->phone."','email':'".$this->email."','establishment_category':'".@$this->establishment_category->name.
    //     "','shop_size':'".@$this->shop_size."','shop_type':'".$this->shop_type."','shop_rent':'".@$this->shop_rent.
    //     "'} ";
    // }
    public function getQRCode($height, $width)
    {
        return "https://quickchart.io/qr?size=200x200&text="
            . url('shop/' . $this->id) . "";
    }
    public function getDuePaymentsDetails(){
        $currentYear = Carbon::now()->year;
        $payments =  Payment::where('shop_id',$this->id)
                        ->where('type','monthly')
                        ->where('is_paid','0')
                        ->where(function ($query) use ($currentYear) {
                            $query->where('year', $currentYear)
                                ->whereIn('month', ['January', 'February', 'March']);
                        })
                        ->orWhere(function ($query) use ($currentYear) {
                            $query->where('year','<', $currentYear);
                        })->get();
        $totalAmount = 0;
        $totalRent = 0;
        $totalTax = 0;
        $totalPaidAmount = 0;
        foreach($payments as $payment){
            $paidAmount = @$payment->collections->whereNotNull('transcation_id')->sum('amount');
            $amount = $payment->getTotalAmountByDate();
            $paidAmountPercentage = round($paidAmount/$amount * 100,2);
            $dueAmountPercentage = 100 -$paidAmountPercentage;
            $interest = round($payment->getInterestValueForArrear()/100 * $dueAmountPercentage,2);
            if($payment->is_arrear){
                $rentAmount =  @$payment->amount;
            }else{
                $rentAmount =  @$payment->shop_rent;
            }
            $duetax= $payment->tax_amount ?? 0;
            $cam_charges= $payment->cam_charges ?? 0;
            $totalPaidAmount = $totalPaidAmount + $paidAmount;
            $totalTax = $totalTax + $interest;
            $totalRent = $totalRent + round(($rentAmount + $duetax + $cam_charges)/100 * $dueAmountPercentage,2);
            $totalAmount = $totalAmount + ($amount - @$paidAmount);
            $payment->update([
               'is_previous_payment' => 1 
            ]);
        }
        $currentYear = Carbon::now()->year;
        if (now()->month < 4) {
            $startYear = $currentYear - 1;
            $endYear = $currentYear;
        } else {
            $startYear = $currentYear;
            $endYear = $currentYear + 1;
        }
        $payments = Payment::where('shop_id', $this->id)
            ->where('month', '!=', Carbon::now()->format('F'))
            ->where('type', 'monthly')
            ->where('is_paid', '0')
            ->where(function ($query) use ($startYear, $endYear) {
                $query->where(function ($query) use ($startYear) {
                    $query->where('year', $startYear)
                        ->whereIn('month', [
                            'April',
                            'May',
                            'June',
                            'July',
                            'August',
                            'September',
                            'October',
                            'November',
                            'December',
                        ]);
                });
                $query->orWhere(function ($query) use ($endYear) {
                    $query->where('year', $endYear)
                        ->whereIn('month', ['January', 'February', 'March']);
                });
            })
            ->get();
        foreach ($payments as $payment) {
            $paidAmount = @$payment->collections->whereNotNull('transcation_id')->sum('amount');
            $amount = $payment->getTotalAmount();
            $paidAmountPercentage = round($paidAmount/$amount * 100,2);
            $dueAmountPercentage = 100 - $paidAmountPercentage;
            if($this->is_arrear){
                $interest = $payment->getInterestValueForArrear();
                $rentAmount =  @$payment->amount;
            }else{
                $interest = $payment->getInterestValue();
                $rentAmount =  @$payment->shop_rent;
            }
            $cam_charges= $payment->cam_charges ?? 0;
            $duetax= $payment->tax_amount ?? 0;
            $totalPaidAmount = $totalPaidAmount + $paidAmount;
            $totalTax = $totalTax + round($interest/100 * $dueAmountPercentage,2);
            $totalRent = $totalRent + round(($rentAmount + $duetax + $cam_charges)/100 * $dueAmountPercentage,2);
            $totalAmount = $totalAmount + ($amount - @$paidAmount);
        }
        return [
            'totalAmount' => $totalAmount, 
            'totalPaidAmount' => $totalPaidAmount, 
            'totalTax' => $totalTax, 
            'totalRent' => $totalRent, 
        ];
    }
    public function getDuePayments()
    {
        $currentYear = Carbon::now()->year;
        $payments = Payment::where('shop_id', $this->id)
            ->where('type', 'monthly')
            ->where('is_paid', '0')
            ->where(function ($query) use ($currentYear) {
                $query->where('year', $currentYear)
                    ->whereIn('month', ['January', 'February', 'March']);
            })
            ->orWhere(function ($query) use ($currentYear) {
                $query->where('year', '<', $currentYear);
            })->get();

        $totalAmount = 0;
        foreach ($payments as $payment) {
            $collectedAmount = @$payment->collections->whereNotNull('transcation_id')->sum('amount');
            $dueAmount = $payment->getTotalAmountByDate() - $collectedAmount;
            // Include tax_amount
            // $dueAmount += $payment->tax_amount ?? 0;

            $totalAmount += $dueAmount;

            $payment->update([
                'is_previous_payment' => 1
            ]);
        }
        return $totalAmount + $this->getCurrentYearPayments();
    }

    public function getCurrentYearPayments()
    {
        $currentYear = Carbon::now()->year;
        if (now()->month < 4) {
            $startYear = $currentYear - 1;
            $endYear = $currentYear;
        } else {
            $startYear = $currentYear;
            $endYear = $currentYear + 1;
        }
        $payments = Payment::where('shop_id', $this->id)
            ->where('month', '!=', Carbon::now()->format('F'))
            ->where('type', 'monthly')
            ->where('is_paid', '0')
            ->where(function ($query) use ($startYear, $endYear) {
                $query->where(function ($query) use ($startYear) {
                    $query->where('year', $startYear)
                        ->whereIn('month', [
                            'April',
                            'May',
                            'June',
                            'July',
                            'August',
                            'September',
                            'October',
                            'November',
                            'December',
                        ]);
                });
                $query->orWhere(function ($query) use ($endYear) {
                    $query->where('year', $endYear)
                        ->whereIn('month', ['January', 'February', 'March']);
                });
            })
            ->get();
        $totalAmount = 0;
        foreach ($payments as $payment) {
            $totalAmount = $totalAmount + ($payment->getTotalAmount() - @$payment->collections->whereNotNull('transcation_id')->sum('amount'));
        }
        return $totalAmount;
    }
}