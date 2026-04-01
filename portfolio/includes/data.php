<?php
/**
 * includes/data.php
 * Centralized data-fetching functions.
 * All queries use prepared statements via PDO.
 */

require_once __DIR__ . '/../config.php';

// ─── Profile ────────────────────────────────────────────────────────────────
function getProfile(): array {
    $stmt = getDB()->query('SELECT * FROM profile LIMIT 1');
    return $stmt->fetch() ?: [];
}

// ─── Skills ──────────────────────────────────────────────────────────────────
function getSkills(): array {
    $stmt = getDB()->query('SELECT * FROM skills ORDER BY sort_order ASC, id ASC');
    return $stmt->fetchAll();
}

// ─── Experience ──────────────────────────────────────────────────────────────
function getExperience(): array {
    $stmt = getDB()->query('SELECT * FROM experience ORDER BY sort_order ASC, id ASC');
    return $stmt->fetchAll();
}

// ─── Projects ────────────────────────────────────────────────────────────────
function getProjects(): array {
    $stmt = getDB()->query('SELECT * FROM projects ORDER BY sort_order ASC, id ASC');
    return $stmt->fetchAll();
}

// ─── Social Links ────────────────────────────────────────────────────────────
function getSocialLinks(): array {
    $stmt = getDB()->query('SELECT * FROM social_links ORDER BY sort_order ASC, id ASC');
    return $stmt->fetchAll();
}

// ─── Contact Message Save ────────────────────────────────────────────────────
function saveContactMessage(string $name, string $email, string $subject, string $message): bool {
    $stmt = getDB()->prepare(
        'INSERT INTO contact_messages (sender_name, sender_email, subject, message)
         VALUES (:name, :email, :subject, :message)'
    );
    return $stmt->execute([
        ':name'    => $name,
        ':email'   => $email,
        ':subject' => $subject,
        ':message' => $message,
    ]);
}

// ─── Admin: Update Profile ───────────────────────────────────────────────────
function updateProfile(array $data): bool {
    $stmt = getDB()->prepare(
        'UPDATE profile SET
            name=:name, nickname=:nickname, role=:role, location=:location,
            email=:email, phone=:phone, whatsapp=:whatsapp, address=:address,
            about=:about, open_to_work=:open_to_work
         WHERE id=1'
    );
    return $stmt->execute($data);
}

// ─── Admin: Upsert Skill ─────────────────────────────────────────────────────
function upsertSkill(array $data): bool {
    if (!empty($data['id'])) {
        $stmt = getDB()->prepare(
            'UPDATE skills SET name=:name, level=:level, category=:category WHERE id=:id'
        );
    } else {
        $stmt = getDB()->prepare(
            'INSERT INTO skills (name, level, category) VALUES (:name, :level, :category)'
        );
    }
    return $stmt->execute($data);
}

function deleteSkill(int $id): bool {
    $stmt = getDB()->prepare('DELETE FROM skills WHERE id=:id');
    return $stmt->execute([':id' => $id]);
}

// ─── Admin: Upsert Project ───────────────────────────────────────────────────
function upsertProject(array $data): bool {
    if (!empty($data['id'])) {
        $stmt = getDB()->prepare(
            'UPDATE projects SET title=:title, description=:description,
             tech_stack=:tech_stack, url=:url WHERE id=:id'
        );
    } else {
        $stmt = getDB()->prepare(
            'INSERT INTO projects (title, description, tech_stack, url)
             VALUES (:title, :description, :tech_stack, :url)'
        );
    }
    return $stmt->execute($data);
}

function deleteProject(int $id): bool {
    $stmt = getDB()->prepare('DELETE FROM projects WHERE id=:id');
    return $stmt->execute([':id' => $id]);
}

// ─── Admin: Upsert Social Link ───────────────────────────────────────────────
function upsertSocialLink(array $data): bool {
    if (!empty($data['id'])) {
        $stmt = getDB()->prepare(
            'UPDATE social_links SET platform=:platform, url=:url, icon_class=:icon_class WHERE id=:id'
        );
    } else {
        $stmt = getDB()->prepare(
            'INSERT INTO social_links (platform, url, icon_class)
             VALUES (:platform, :url, :icon_class)'
        );
    }
    return $stmt->execute($data);
}

function deleteSocialLink(int $id): bool {
    $stmt = getDB()->prepare('DELETE FROM social_links WHERE id=:id');
    return $stmt->execute([':id' => $id]);
}

// ─── Admin: Get All Messages ─────────────────────────────────────────────────
function getContactMessages(): array {
    $stmt = getDB()->query('SELECT * FROM contact_messages ORDER BY created_at DESC');
    return $stmt->fetchAll();
}

function markMessageRead(int $id): bool {
    $stmt = getDB()->prepare('UPDATE contact_messages SET is_read=1 WHERE id=:id');
    return $stmt->execute([':id' => $id]);
}
