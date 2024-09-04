<?php

namespace App\Orchid\Screens;

use App\Models\Task;
use App\Orchid\Layouts\TaskEditLayout;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\ModalToggle;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Screen;
use Orchid\Screen\TD;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class TaskScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            'tasks' => Task::all(),
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Simple To-Do List';
    }

    /**
     * Displays a description on the user's screen
     * directly under the heading.
     */
    public function description(): ?string
    {
        return "Orchid Quickstart";
    }

    // create task
    public function create(Request $request)
    {
        // Validate form data, save task to database, etc.
        $request->validate([
            'task.name' => 'required|max:255',
        ]);

        $task = new Task();
        $task->name = $request->input('task.name');
        $task->save();
    }

    // delete task
    public function delete(Task $task)
    {
        $task->delete();
    }

    // edit task
    public function editTask(Request $request, Task $task)
    {
        $request->validate([
            'task.name' => [
                'required'
            ],
        ]);
        $task->name = $request->input('task.name');
        $task->save();

        Toast::info(__('Task was updated.'));

    }

    /**
     * Loads task data when opening the modal window.
     *
     * @return array
     */
    public function loadُTaskOnOpenModal(Task $task): iterable
    {
        return [
            'task' => $task
        ];
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            ModalToggle::make('Add Task')
                ->modal('taskModal')
                ->method('create')
                ->icon('plus'),
        ];
    }



    /**
     * The screen's layout elements.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): iterable
    {
        return [

            // edit modal
            Layout::modal('editTaskModal', TaskEditLayout::class)
                ->deferred('loadُTaskOnOpenModal'),
            // end edit modal

            Layout::table('tasks', [
                TD::make('id', 'شناسه'),
                TD::make('name', 'نام'),

                // edit task button
                TD::make('name', __('ویرایش'))
                    ->render( fn (Task $task) => ModalToggle::make($task->name)
                        ->modal('editTaskModal')
                        ->modalTitle('ویرایش')
                        ->method('editTask')
                        ->asyncParameters([
                            'task' => $task->id,
                        ])),
                // end edit button

                // delete task
                TD::make('Actions')
                    ->alignRight()
                    ->render(function (Task $task) {
                        return Button::make('Delete Task')
                            ->confirm('بعد از حذف این آیتم دیگر به آن دسترسی ندارید')
                            ->method('delete', ['task' => $task->id]);
                    }),
                // end delete
            ]),
            // create model modal
            Layout::modal('taskModal', Layout::rows([
                Input::make('task.name')
                    ->title('Name')
                    ->placeholder('Enter task name')
                    ->help('The name of the task to be created.'),
            ]))->title('Create Task')->applyButton('Add Task'),
            // end model modal
        ];
    }
}
