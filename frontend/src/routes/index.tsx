import { createFileRoute } from '@tanstack/react-router'
import { useGSAP } from '@gsap/react'
import gsap from 'gsap'
import { FormEvent, useRef, useState } from 'react'
import { createTask, getTasks, type Task } from '~/utils/api'

gsap.registerPlugin(useGSAP)

export const Route = createFileRoute('/')({
  component: Home,
})

function Home() {
  const pageRef = useRef<HTMLElement>(null)
  const [tasks, setTasks] = useState<Task[]>([])
  const [title, setTitle] = useState('')
  const [loading, setLoading] = useState(true)
  const [saving, setSaving] = useState(false)
  const [message, setMessage] = useState('')
  const [error, setError] = useState('')

  useGSAP(() => {
    if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) return

    gsap
      .timeline({ defaults: { ease: 'power3.out' } })
      .from('.hero-copy > *', { y: 24, autoAlpha: 0, duration: 0.7, stagger: 0.08 })
      .from('.preview-card', { y: 28, autoAlpha: 0, duration: 0.8 }, '-=0.5')
      .from('.task-panel', { y: 18, autoAlpha: 0, duration: 0.5 }, '-=0.4')
  }, { scope: pageRef })

  useGSAP(() => {
    getTasks()
      .then(setTasks)
      .catch(() => setError('Tugas belum dapat dimuat. Pastikan Laravel sedang berjalan.'))
      .finally(() => setLoading(false))
  }, { scope: pageRef })

  async function handleSubmit(event: FormEvent<HTMLFormElement>) {
    event.preventDefault()
    if (!title.trim() || saving) return

    setSaving(true)
    setError('')
    setMessage('')

    try {
      const result = await createTask(title.trim())
      setTasks(result.tasks)
      setTitle('')
      setMessage('Tugas berhasil disimpan.')
    } catch {
      setError('Tugas belum tersimpan. Coba lagi.')
    } finally {
      setSaving(false)
    }
  }

  return (
    <main ref={pageRef} className="app-shell">
      <nav className="topbar" aria-label="Navigasi utama">
        <a className="brand" href="/" aria-label="KEPL Planner beranda">
          <span className="brand-mark" aria-hidden="true"><i /><i /><i /></span>
          <span>kepl<span className="brand-dot">.</span></span>
        </a>
        <div className="nav-links">
          <a href="#planner">Cara kerja</a>
          <a href="#tasks">Tugas saya</a>
          <a className="nav-cta" href="#planner">Mulai sekarang</a>
        </div>
        <a className="mobile-cta" href="#planner">Mulai</a>
      </nav>

      <div className="announcement" role="status">
        <span>Ruang yang lebih tenang untuk pekerjaan yang lebih jelas.</span>
        <a href="#planner">Tambahkan tugas pertama <span aria-hidden="true">→</span></a>
      </div>

      <header className="hero">
        <div className="hero-copy">
          <p className="eyebrow"><span className="eyebrow-mark" aria-hidden="true" /> KEPL / task planner</p>
          <h1>Clarity, <em>akhirnya.</em></h1>
          <p className="intro">Simpan hal yang perlu kamu kerjakan, satu langkah pada satu waktu. Sederhana, fokus, dan siap dipakai.</p>
          <div className="hero-actions">
            <a className="primary-cta" href="#planner">Mulai gratis <span aria-hidden="true">→</span></a>
            <span className="microcopy"><span className="micro-dot" aria-hidden="true" /> Tanpa akun. Langsung mulai.</span>
          </div>
        </div>

        <div className="preview-card" aria-label="Preview tampilan KEPL Planner">
          <div className="preview-window">
            <div className="preview-sidebar">
              <div className="preview-user"><span className="avatar">F</span><span>Falah</span><span className="preview-chevron">⌄</span></div>
              <p className="preview-label">Workspace</p>
              <div className="preview-side-item active"><span>◷</span> Hari ini</div>
              <div className="preview-side-item"><span>□</span> Semua tugas</div>
              <div className="preview-side-item"><span>+</span> Tambah tugas</div>
              <p className="preview-label preview-label-bottom">Project</p>
              <div className="preview-side-item"><span className="side-dot coral" /> KEPL Planner</div>
              <div className="preview-side-item"><span className="side-dot teal" /> Semester 5</div>
            </div>
            <div className="preview-main">
              <div className="preview-toolbar"><span>Hari ini</span><span className="preview-view">☷ View</span></div>
              <p className="preview-date">Selasa, 8 September</p>
              {['Review sprint backlog', 'Rancang halaman planner', 'Siapkan demo untuk tim'].map((item, index) => (
                <div className="preview-task" key={item}><span className="preview-check" /><span>{item}</span><small>{['09:30', '11:00', '14:00'][index]}</small></div>
              ))}
              <div className="preview-add"><span>+</span> Tambah tugas</div>
            </div>
          </div>
          <div className="preview-accent preview-accent-one" aria-hidden="true" />
          <div className="preview-accent preview-accent-two" aria-hidden="true" />
        </div>
      </header>

      <div className="task-panel" id="planner">
        <section className="panel panel-form" aria-labelledby="add-task-heading">
          <div className="section-heading">
            <span className="section-index">01</span>
            <div><p className="section-kicker">Mulai dari sini</p><h2 id="add-task-heading">Tambahkan tugas</h2></div>
          </div>
          {message && <p className="notice" role="status">{message}</p>}
          {error && <p className="errors" role="alert">{error}</p>}
          <form onSubmit={handleSubmit}>
            <label htmlFor="title">Apa yang perlu kamu selesaikan?</label>
            <div className="input-wrap">
              <input id="title" value={title} onChange={(event) => setTitle(event.target.value)} maxLength={120} autoComplete="off" required aria-describedby="title-hint title-count" />
              <span className="input-count" id="title-count" aria-live="polite">{title.length}/120</span>
            </div>
            <div className="form-meta"><span id="title-hint">Buat singkat dan spesifik.</span><button type="submit" disabled={saving}>{saving ? 'Menyimpan...' : <><span aria-hidden="true">+</span> Simpan tugas</>}</button></div>
          </form>
        </section>

        <section className="panel panel-list" id="tasks" aria-labelledby="task-list-heading">
          <div className="section-heading">
            <span className="section-index">02</span>
            <div><p className="section-kicker">Yang sedang berjalan</p><h2 id="task-list-heading">Daftar tugas <span className="task-count" aria-label={`${tasks.length} tugas`}>{tasks.length}</span></h2></div>
          </div>
          {loading ? <p className="empty">Memuat tugas...</p> : tasks.length ? tasks.map((task) => (
            <article className="task" key={`${task.title}-${task.created_at}`}><span className="task-marker" aria-hidden="true" /><p className="task-title">{task.title}</p><time className="task-date">{task.created_at}</time></article>
          )) : <div className="empty"><span className="empty-icon" aria-hidden="true">+</span><p>Belum ada tugas. Tambahkan satu langkah kecil untuk memulai.</p></div>}
        </section>
      </div>

      <footer className="footer"><span>KEPL</span><span>Planner tugas yang sederhana, supaya pikiran punya ruang.</span></footer>
    </main>
  )
}
