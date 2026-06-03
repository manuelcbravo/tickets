declare module 'frappe-gantt' {
    export type GanttTask = {
        id: string;
        name: string;
        start: string;
        end: string;
        progress?: number;
        dependencies?: string;
        custom_class?: string;
        description?: string;
        activityId?: string;
        status?: string;
        priority?: string;
        responsible?: string;
    };

    export type GanttPopupContext = {
        task: GanttTask;
        set_title: (value: string) => void;
        set_subtitle: (value: string) => void;
        set_details: (value: string) => void;
    };

    export type GanttOptions = {
        view_mode?: 'Day' | 'Week' | 'Month' | 'Year';
        view_mode_select?: boolean;
        language?: string;
        readonly?: boolean;
        readonly_dates?: boolean;
        readonly_progress?: boolean;
        popup_on?: 'click' | 'hover';
        today_button?: boolean;
        popup?: false | ((context: GanttPopupContext) => string | false | void);
        on_click?: (task: GanttTask) => void;
        on_date_change?: (task: GanttTask, start: Date, end: Date) => void;
        on_progress_change?: (task: GanttTask, progress: number) => void;
        on_view_change?: (mode: { name: string }) => void;
        bar_height?: number;
        padding?: number;
        container_height?: 'auto' | number;
        scroll_to?: 'today' | 'start' | 'end' | string;
    };

    export default class Gantt {
        constructor(
            wrapper: string | HTMLElement | SVGElement,
            tasks: GanttTask[],
            options?: GanttOptions,
        );

        refresh(tasks: GanttTask[]): void;
        change_view_mode(mode?: GanttOptions['view_mode'], maintain_pos?: boolean): void;
    }
}
