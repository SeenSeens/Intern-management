export const permissions = {
  project_manager: [
    'create_project',
    'edit_project',
    'assign_mentor',
    'assign_intern',
    'view_all_projects',
    'view_all_reports',
    'manage_settings'
  ],
  mentor: [
    'view_assigned_projects',
    'assign_intern_to_project',
    'view_intern_tasks',
    'grade_tasks',
    'review_reports'
  ],
  intern: [
    'view_own_projects',
    'create_tasks',
    'create_task_details',
    'update_task_status',
    'submit_reports'
  ]
}
