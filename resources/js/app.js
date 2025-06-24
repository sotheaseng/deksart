// Mobile navigation toggle
document.addEventListener("DOMContentLoaded", () => {
    const mobileToggle = document.querySelector(".mobile-nav-toggle")
    const navLinks = document.querySelector(".nav-links")
  
    if (mobileToggle && navLinks) {
      mobileToggle.addEventListener("click", () => {
        navLinks.classList.toggle("mobile-open")
      })
    }
  
    // Auto-hide alerts after 5 seconds
    const alerts = document.querySelectorAll(".alert")
    alerts.forEach((alert) => {
      if (alert.classList.contains('alert-persistent')) return;
      setTimeout(() => {
        alert.style.opacity = "0"
        setTimeout(() => {
          alert.remove()
        }, 300)
      }, 5000)
    })
  
    // Confirm delete actions
    const deleteButtons = document.querySelectorAll(".btn-delete")
    deleteButtons.forEach((button) => {
      button.addEventListener("click", (e) => {
        if (!confirm("Are you sure you want to delete this item?")) {
          e.preventDefault()
        }
      })
    })
  
    // Table row highlighting
    const tableRows = document.querySelectorAll(".table tbody tr")
    tableRows.forEach((row) => {
      row.addEventListener("mouseenter", function () {
        this.style.backgroundColor = "#f9fafb"
      })
  
      row.addEventListener("mouseleave", function () {
        this.style.backgroundColor = ""
      })
    })
  })
  
  // Form validation helper
  function validateForm(formId) {
    const form = document.getElementById(formId)
    const requiredFields = form.querySelectorAll("[required]")
    let isValid = true
  
    requiredFields.forEach((field) => {
      if (!field.value.trim()) {
        field.style.borderColor = "#ef4444"
        isValid = false
      } else {
        field.style.borderColor = "#d1d5db"
      }
    })
  
    return isValid
  }
  
  // Status color helper
  function getStatusBadgeClass(status) {
    switch (status) {
      case "available":
      case "completed":
        return "badge-success"
      case "occupied":
      case "cancelled":
        return "badge-danger"
      case "maintenance":
      case "pending":
      case "in_progress":
        return "badge-warning"
      case "cleaning":
        return "badge-info"
      default:
        return "badge-secondary"
    }
  }
  