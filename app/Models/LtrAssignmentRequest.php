<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class LtrAssignmentRequest extends Model
{
    use HasUuids, SoftDeletes;

    protected $table = 'ltr_assignment_requests';

    protected $fillable = [
        'user_id',
        'assignment_type',
        'full_name',
        'nidn',
        'faculty',
        'academic_positions',
        'start_date',
        'end_date',
        'academic_year',
        'institution_name',
        'institution_address',
        'research_title',
        'estimated_budget',
        'leader_name',
        'pic_name',
        'report_file_path',
        'publication_link',
        'status',
        'letter_number',
        'submitted_at',
        'reviewed_at',
    ];

    protected $casts = [
        'academic_positions' => 'array',
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'estimated_budget' => 'decimal:2',
        'submitted_at' => 'datetime',
        'reviewed_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function members(): HasMany
    {
        return $this->hasMany(LtrAssignmentMember::class);
    }

    public function review(): HasOne
    {
        return $this->hasOne(LtrAssignmentReview::class, 'assignment_request_id');
    }

    /**
     * Generate nomor surat otomatis
     * Format: 309/A/LPPM-UNSAP/XII/2025
     */
    public static function generateLetterNumber(): string
    {
        // Get current year and month in Roman numerals
        $year = now()->format('Y');
        $month = self::getRomanMonth(now()->month);

        // Get last number for this month
        $lastLetter = self::whereYear('created_at', now()->year)
            ->whereMonth('created_at', now()->month)
            ->whereNotNull('letter_number')
            ->orderBy('created_at', 'desc')
            ->first();

        $number = 1;
        if ($lastLetter && $lastLetter->letter_number) {
            // Extract number from format: 309/A/LPPM-UNSAP/XII/2025
            preg_match('/^(\d+)\//', $lastLetter->letter_number, $matches);
            if (isset($matches[1])) {
                $number = intval($matches[1]) + 1;
            }
        }

        return sprintf('%d/A/LPPM-UNSAP/%s/%s', $number, $month, $year);
    }

    /**
     * Convert month number to Roman numerals
     */
    private static function getRomanMonth(int $month): string
    {
        $romans = [
            1 => 'I',
            2 => 'II',
            3 => 'III',
            4 => 'IV',
            5 => 'V',
            6 => 'VI',
            7 => 'VII',
            8 => 'VIII',
            9 => 'IX',
            10 => 'X',
            11 => 'XI',
            12 => 'XII',
        ];

        return $romans[$month] ?? 'I';
    }
}
