<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KEPL Planner</title>
    <style>
        :root { --ink: #17252a; --muted: #647277; --paper: #f3f0e8; --accent: #ee6c4d; --line: #d8d4c8; }
        * { box-sizing: border-box; }
        body { margin: 0; min-height: 100vh; color: var(--ink); background: radial-gradient(circle at 85% 10%, #f9c74f 0 10%, transparent 11%), var(--paper); font-family: Georgia, 'Times New Roman', serif; }
        .shell { width: min(100% - 40px, 960px); margin: 0 auto; padding: 64px 0; }
        .eyebrow { margin: 0 0 14px; color: var(--accent); font: 700 12px/1.2 Arial, sans-serif; letter-spacing: 2px; text-transform: uppercase; }
        h1 { max-width: 680px; margin: 0; font-size: clamp(44px, 8vw, 88px); line-height: .92; font-weight: 500; }
        .intro { max-width: 530px; margin: 24px 0 42px; color: var(--muted); font: 17px/1.6 Arial, sans-serif; }
        .workspace { display: grid; grid-template-columns: 1fr 1.25fr; gap: 48px; align-items: start; }
        .panel { border-top: 2px solid var(--ink); padding-top: 18px; }
        h2 { margin: 0 0 18px; font-size: 23px; font-weight: 500; }
        label { display: block; margin-bottom: 8px; color: var(--muted); font: 12px Arial, sans-serif; text-transform: uppercase; letter-spacing: 1px; }
        input { width: 100%; padding: 15px 0; border: 0; border-bottom: 1px solid var(--ink); outline: 0; background: transparent; color: var(--ink); font: 18px Georgia, serif; }
        input:focus { border-bottom-color: var(--accent); }
        button { margin-top: 22px; padding: 13px 20px; border: 0; background: var(--accent); color: #fff; cursor: pointer; font: 700 12px Arial, sans-serif; letter-spacing: 1px; text-transform: uppercase; }
        button:hover { background: var(--ink); }
        .notice { margin: 0 0 18px; color: #34745b; font: 14px Arial, sans-serif; }
        .errors { margin: 0 0 18px; color: #b33a2d; font: 14px/1.5 Arial, sans-serif; }
        .task { display: flex; justify-content: space-between; gap: 20px; padding: 18px 0; border-bottom: 1px solid var(--line); }
        .task-title { margin: 0; font-size: 20px; }
        .task-date { color: var(--muted); font: 12px Arial, sans-serif; white-space: nowrap; }
        .empty { padding: 28px 0; color: var(--muted); font: 15px/1.5 Arial, sans-serif; }
        @media (max-width: 680px) { .shell { padding: 38px 0; } .workspace { grid-template-columns: 1fr; gap: 42px; } }
    </style>
</head>
<body>
    <main class="shell">
        <p class="eyebrow">KEPL / semester five</p>
        <h1>Make room for the work that matters.</h1>
        <p class="intro">A small, focused planner for turning the next useful idea into a task you can actually finish.</p>

        <div class="workspace">
            <section class="panel" aria-labelledby="add-task-heading">
                <h2 id="add-task-heading">Add a task</h2>
                @if (session('success'))
                    <p class="notice">{{ session('success') }}</p>
                @endif
                @if ($errors->any())
                    <div class="errors" role="alert">{{ $errors->first('title') }}</div>
                @endif
                <form method="POST" action="{{ route('tasks.store') }}">
                    @csrf
                    <label for="title">What needs your attention?</label>
                    <input id="title" name="title" value="{{ old('title') }}" maxlength="120" required autofocus>
                    <button type="submit">Add to list</button>
                </form>
            </section>

            <section class="panel" aria-labelledby="task-list-heading">
                <h2 id="task-list-heading">Your list <span aria-label="{{ count($tasks) }} tasks">({{ count($tasks) }})</span></h2>
                @forelse ($tasks as $task)
                    <article class="task">
                        <p class="task-title">{{ $task['title'] }}</p>
                        <time class="task-date">{{ $task['created_at'] }}</time>
                    </article>
                @empty
                    <p class="empty">Nothing here yet. Add one small, clear next step.</p>
                @endforelse
            </section>
        </div>
    </main>
</body>
</html>