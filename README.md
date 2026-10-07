# Presentily 

> **AI-powered PFE presentation and jury preparation platform for students.**

Presentily is a web platform designed to help students prepare their **Projet de Fin d'Études (PFE)** from presentation creation to jury preparation.

Instead of simply generating PowerPoint slides, Presentily focuses on the complete **PFE defense experience**:

*  Structure the student's project information
*  Generate a presentation adapted to the provided content
*  Generate a speaker script to help students present their work
*  Simulate a PFE jury
*  Generate potential jury questions
*  Analyze student answers
*  Provide feedback to improve the defense

The goal is simple:

> **Help students transform their PFE work into a clear presentation and prepare them for the questions they may face during their defense.**

---

##  Features

###  AI Presentation Generation

Students provide information about their PFE, including:

* Project title
* Academic field
* Institution
* University
* Supervisor
* Problem statement
* Objectives
* Proposed solution
* Technologies
* Architecture
* Results

Presentily uses this information to generate a structured presentation while keeping the generated content grounded in the student's project.

### Presentation Script

For each presentation, Presentily can generate a speaking script designed to help the student understand:

* What to say
* How to introduce each slide
* How to explain technical concepts
* How to transition between slides
* How to present the project clearly to a jury

###  AI Jury Simulation

Students can practice their defense through an AI-powered jury simulation.

The system can generate questions from different perspectives:

*  Technical
*  Business
*  Pedagogical

The student answers the questions and receives AI-powered feedback.

###  Answer Analysis

Student answers can be analyzed according to criteria such as:

* Relevance
* Technical accuracy
* Clarity
* Completeness
* Confidence
* Missing information

The objective is not simply to give a score, but to help students understand **how to improve their answers before the real defense**.

###  PDF Processing

Presentily supports extracting information from PDF documents so that the student's existing PFE material can be used as part of the generation workflow.

###  Asynchronous AI Processing

AI generation tasks are processed asynchronously using Laravel queues.

This prevents long-running AI operations from blocking the main application.

Examples include:

* Presentation generation
* Jury question generation
* Answer analysis

---

##  Architecture

Presentily is built as a modern full-stack SaaS application.

```text
                    ┌──────────────────────┐
                    │       Student        │
                    └──────────┬───────────┘
                               │
                               ▼
                    ┌──────────────────────┐
                    │   Vue / Inertia.js   │
                    │     Frontend         │
                    └──────────┬───────────┘
                               │
                               ▼
                    ┌──────────────────────┐
                    │   Laravel Backend    │
                    │                      │
                    │ Controllers          │
                    │ Services             │
                    │ Validation           │
                    │ Authentication       │
                    └───────┬───────┬──────┘
                            │       │
                 ┌──────────┘       └──────────┐
                 ▼                             ▼
        ┌─────────────────┐          ┌─────────────────┐
        │   PostgreSQL    │          │   Laravel Queue │
        │    Database     │          │      Jobs       │
        └─────────────────┘          └────────┬────────┘
                                               │
                                               ▼
                                      ┌─────────────────┐
                                      │     OpenAI      │
                                      │   AI Services   │
                                      └────────┬────────┘
                                               │
                         ┌─────────────────────┼─────────────────────┐
                         ▼                     ▼                     ▼
                  Presentation           Jury Questions       Answer Analysis
                    Generation             Generation             Feedback
```

---

##  Tech Stack

### Backend

* **Laravel 12**
* **PHP 8.2+**
* Laravel Sanctum
* Laravel Queues
* Laravel Breeze

### Frontend

* **Vue.js**
* **Inertia.js**
* Tailwind CSS
* Vite

### Database

* **PostgreSQL**

### Artificial Intelligence

* **OpenAI API**
* Structured AI generation
* AI-powered question generation
* AI-powered answer analysis

### Documents

* PDF parsing
* FPDI
* FPDF
* PDF Parser

### Email

* Resend

---

##  Main Workflow

```text
Student
   │
   ▼
Enter PFE information
   │
   ▼
Provide project context
   │
   ▼
Generate presentation
   │
   ▼
AI processing
   │
   ▼
Presentation + speaker script
   │
   ▼
Practice jury simulation
   │
   ▼
Answer jury questions
   │
   ▼
AI answer analysis
   │
   ▼
Feedback & improvement
```

---

##  Why Presentily?

Traditional presentation tools focus mainly on creating slides.

Presentily focuses on the **student's entire PFE defense preparation**.

The platform connects three important stages:

```text
              PFE PROJECT
                   │
          ┌────────┴────────┐
          ▼                 ▼
   PRESENTATION          PREPARATION
          │                 │
          ▼                 ▼
      Slides +         Jury Questions
       Script                 │
                             ▼
                       Answer Analysis
                             │
                             ▼
                         Feedback
```

This makes Presentily more than a presentation generator.

It is a **PFE defense preparation platform**.

---

##  Authentication & User Management

Presentily includes user authentication and account management.

The application also uses a credit-based system for AI-powered features.

Examples include:

* Presentation credits
* Jury simulation credits

---

##  Product Model

Presentily is designed as a SaaS platform with different usage plans.

The platform can provide different levels of access depending on the student's needs, including presentation generation and jury simulation credits.

---

##  Project Structure

```text
presentilyfinale/
│
├── app/
│   ├── Http/
│   ├── Jobs/
│   ├── Models/
│   └── Services/
│
├── database/
│   ├── migrations/
│   ├── factories/
│   └── seeders/
│
├── resources/
│   ├── js/
│   └── css/
│
├── routes/
│
├── tests/
│
├── public/
│
├── storage/
│
├── composer.json
├── package.json
└── README.md
```

---

##  Installation

### Requirements

* PHP 8.2+
* Composer
* Node.js 20+
* npm
* PostgreSQL
* OpenAI API key

### Clone the repository

```bash
git clone https://github.com/fadwadhmaid/presentilyfinale.git

cd presentilyfinale
```

### Install PHP dependencies

```bash
composer install
```

### Install frontend dependencies

```bash
npm install
```

### Configure environment

```bash
cp .env.example .env
```

Configure your database and required API credentials in `.env`.

### Generate application key

```bash
php artisan key:generate
```

### Run migrations

```bash
php artisan migrate
```

### Build frontend

```bash
npm run build
```

### Start the application

```bash
php artisan serve
```

For local development with queues and Vite:

```bash
composer run dev
```

---

##  Queue Processing

Presentily uses Laravel background jobs for long-running AI operations.

Typical jobs include:

```text
GeneratePresentationJob
        │
        ▼
     OpenAI
        │
        ▼
 Generated presentation
```

```text
GenerateQuestionsJob
        │
        ▼
     OpenAI
        │
        ▼
  Jury questions
```

```text
AnalyzeAnswerJob
        │
        ▼
     OpenAI
        │
        ▼
 Answer analysis
```

This architecture allows expensive AI operations to run independently from the user's main request.

---

##  Security

Sensitive credentials should never be committed to the repository.

Create your local environment file from:

```bash
.env.example
```

Never commit:

```text
.env
```

API keys should always be stored as environment variables.

---

##  Project Status

Presentily is an evolving project focused on improving the PFE preparation experience.

Current areas of development include:

* AI presentation generation
* Speaker scripts
* Jury simulation
* AI answer analysis
* Presentation export
* UI/UX improvements
* Additional PFE domains
* More presentation themes

---

##  Author

**Fadwa Dhmaid**

Software Engineer & AI Developer

GitHub:
https://github.com/fadwadhmaid

---

##  License

This project is currently developed as a personal SaaS project.

---

 If you find the project interesting, feel free to explore the repository and follow its development.
