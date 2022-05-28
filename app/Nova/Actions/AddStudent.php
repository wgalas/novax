<?php

namespace App\Nova\Actions;

use App\Models\CounsellingStudent;
use App\Models\Student;
use Illuminate\Bus\Queueable;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Actions\Action;
use Illuminate\Support\Collection;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Fields\BelongsToMany;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class AddStudent extends Action
{
    use InteractsWithQueue, Queueable;
    public $branch;
    public function __construct($id)
    {
        $this->branch = $id;
    }

    /**
     * Perform the action on the given models.
     *
     * @param  \Laravel\Nova\Fields\ActionFields  $fields
     * @param  \Illuminate\Support\Collection  $models
     * @return mixed
     */
    public function handle(ActionFields $fields, Collection $models)
    {
        foreach ($models as $model) {
            if($model->counsellingStudents()->where('student_id', $fields['student'])->count()) {
                return Action::danger('Student was already added!');
            }
            CounsellingStudent::create([
                'student_id' => $fields['student'],
                'counselling_id' => $model->id,
            ]);
        }
    }

    /**
     * Get the fields available on the action.
     *
     * @return array
     */
    public function fields()
    {
        $branch = $this->branch;
        return [
            Select::make('Student 1', 'student')
                ->help('Enter Student No.')
                ->searchable()
                ->options( function () use ($branch) {
                    $students = Student::where('branch_id', $branch)->get();
                    $result = [];
                    foreach ($students as $item) {
                        $result[$item->full_name . ' - ' . $item->student_number] = $item->id;
                    }

                    return $result;
                })
                ->required(),
        ];
    }
}
