<?php

namespace Modules\HumanResource\Repositories;

use App\Traits\ImageStore;
use Carbon\CarbonPeriod;
use DateTime;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Modules\HumanResource\Entities\Attendance;
use Carbon\Carbon;
use Modules\HumanResource\Entities\Event;
use Modules\HumanResource\Entities\Holiday;
use Modules\RolePermission\Repositories\RoleRepository;

class EventRepository implements EventRepositoryInterface
{

    use ImageStore;
    public function all()
    {
        return Event::latest()->get();
    }

    public function create(array $data)
    {
        $event = new Event();
        if (!empty($data['image'])) {
            $event->image = isset($data['image']) ? $this->saveImage($data['image']) : '';
        }
        $event->title = $data['title'];
        $event->for_whom = $data['for_whom'];
        $event->location = $data['location'];
        $event->description = $data['description'];
        $event->from_date = date('Y-m-d',strtotime($data['from_date']));
        $event->to_date = date('Y-m-d',strtotime($data['to_date']));
        $event->save();

        return $event;
    }

    public function find($id)
    {
        return Event::find($id);
    }

    public function update(array $data, $id)
    {
        $event = Event::find($id);

        if (!empty($data['image'])) {
            $event->image = isset($data['image']) ? $this->saveImage($data['image']) : $event->image;
        }

        $event->title = $data['title'];
        $event->for_whom = $data['for_whom'];
        $event->location = $data['location'];
        $event->description = $data['description'];
        $event->from_date = date('Y-m-d',strtotime($data['from_date']));
        $event->to_date = date('Y-m-d',strtotime($data['to_date']));
        $event->save();

        return $event;
    }

    public function delete($id)
    {
        Event::destroy($id);
    }

    public function roleWiseEvents()
    {
        return Event::where('for_whom','all')->orWhere('for_whom',Auth::user()->role->name)->get();
    }
}
