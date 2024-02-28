<?php

namespace App\Http\Controllers;

use App\Entities\Event;
use Illuminate\Http\Request;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Common\Persistence\ObjectRepository;

class EventController extends Controller
{
    protected $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function create(Request $request)
    {
        $event = new Event($request->input('name'), $request->input('location'));
        $this->em->persist($event);
        $this->em->flush();

        return redirect()->route('events.index')->with('message', 'Event created successfully');
    }

    public function index()
    {
        $events = $this->em->getRepository(Event::class)->findAll();

        return view('events.index', ['events' => $events]);
    }

    public function show($id)
    {
        $event = $this->em->getRepository(Event::class)->find($id);

        if (!$event) {
            return redirect()->route('events.index')->with('error', 'Event not found');
        }

        return view('events.show', ['event' => $event]);
    }

    public function update(Request $request, $id)
    {
        $event = $this->em->getRepository(Event::class)->find($id);

        if (!$event) {
            return redirect()->route('events.index')->with('error', 'Event not found');
        }

        $event->setName($request->input('name'));
        $event->setLocation($request->input('location'));

        $this->em->flush();

        return redirect()->route('events.index')->with('message', 'Event updated successfully');
    }

    public function delete($id)
    {
        $event = $this->em->getRepository(Event::class)->find($id);

        if (!$event) {
            return redirect()->route('events.index')->with('error', 'Event not found');
        }

        $this->em->remove($event);
        $this->em->flush();

        return redirect()->route('events.index')->with('message', 'Event deleted successfully');
    }
}