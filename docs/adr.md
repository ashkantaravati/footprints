# Architectural Decision Notes

## ADR-001: Laravel 12 for shared-hosting practicality
Laravel 13 is the latest stable release in June 2026, but Laravel 12 remains the practical baseline for broad shared-hosting PHP 8.2 support. The repository uses Laravel 12 conventions and can be upgraded once PHP 8.3+ is common on target hosts.

## ADR-002: Footprints are activity records
Footprints are not full event sourcing. They power activity streams, notifications, and audits while business tables remain authoritative.

## ADR-003: Polling before WebSockets
Polling remains the realtime strategy because it works on inexpensive shared hosting without queue or socket infrastructure.
