export type Task = {
  title: string
  created_at: string
}

type TasksResponse = {
  tasks: Task[]
}

const apiUrl = (path: string) => `${import.meta.env.VITE_API_BASE_URL ?? 'http://127.0.0.1:8000'}${path}`

function xsrfToken() {
  const cookie = document.cookie.split('; ').find((item) => item.startsWith('XSRF-TOKEN='))
  return cookie ? decodeURIComponent(cookie.split('=').slice(1).join('=')) : ''
}

async function request<T>(path: string, options?: RequestInit): Promise<T> {
  const response = await fetch(apiUrl(path), {
    credentials: 'include',
    headers: {
      Accept: 'application/json',
      ...(options?.body ? { 'Content-Type': 'application/json' } : {}),
      ...(xsrfToken() ? { 'X-XSRF-TOKEN': xsrfToken() } : {}),
      ...options?.headers,
    },
    ...options,
  })

  if (!response.ok) throw new Error('API request failed')
  return response.json() as Promise<T>
}

export async function getTasks() {
  const result = await request<TasksResponse>('/api/tasks')
  return result.tasks
}

export async function createTask(title: string) {
  return request<TasksResponse>('/api/tasks', {
    method: 'POST',
    body: JSON.stringify({ title }),
  })
}